<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Jobs\EmailCleaner;
use App\Models\EmailFinishedList;
use App\Models\EmailTotalList;
use App\Models\FileUploads;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\URL;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\DataTables\Facades\DataTables;
use ZipArchive;
use Illuminate\Bus\Batch;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Bus;
use App\Models\FailedJob;

class EmailController extends Controller
{
    public function __construct()
    {
        globalDashboardAssets();
    }

    public function index()
    {
        addVendors(['email-upload']);
        return view('dashboard.email-upload', ['title' => 'Email Upload']);
    }

    public function createUpdate($newCredit)
    {
        $user = User::where('id', auth()->user()->id)->first();
        $currentCredit = $user->credit;
        $newCredit = $currentCredit - $newCredit;
        $user->update(['credit' => $newCredit]);
    }

    public function emailMapping(Request $request)
    {
        $path = $request->file('file');
        $data = Excel::toArray([], $path);
        $html = '';

        foreach ($data[0][0] as $key => $value) {
            $html .= '<option value="' . $key . '">' . ($key + 1) . '</option>';
        }
        return response()->json(['status' => 200, 'data' => $html]);
    }

    public function checkTitle($filteredData)
    {
        $first_key = array_key_first($filteredData);
        $return = $filteredData[$first_key];
        foreach ($filteredData[$first_key] as $key => $value) {
            $check_email = explode('@', $value);
            if (count($check_email) > 1) {
                $check_email = explode('.', $check_email[1]);
                if (count($check_email) > 1) {
                    $return = false;
                    break;
                }
            }
        }
        return $return;
    }

    public function checkEmailColumn($filteredData)
    {
        $return = false;
        foreach ($filteredData as $row_key => $row_value) {
            foreach ($row_value as $key => $value) {
                $check_email = explode('@', $value);
                if (count($check_email) > 1) {
                    $check_email = explode('.', $check_email[1]);
                    if (count($check_email) > 1) {
                        $return = $key;
                        break;
                    }
                }
            }
        }
        return $return;
    }

    public function upload(Request $request)
    {
        $path = $request->file('file');
        $data = Excel::toArray([], $path);
        $filteredData = array_filter($data[0], 'removeNullArray');
        $file_title = $this->checkTitle($filteredData);
        $email_column = $this->checkEmailColumn($filteredData);

        if (auth()->user()->role == 'user') {

            $countTotalEmail = EmailTotalList::where('userID', auth()->user()->id)->get()->count();

            if ($countTotalEmail >= auth()->user()->credit) {
                return response()->json(['status' => 201, 'msg' => 'Your limit has been 0']);
            }

            if (count($filteredData) >= auth()->user()->credit) {
                $sum = auth()->user()->credit - $countTotalEmail;
                return response()->json(['status' => 201, 'msg' => 'Already used emails: ' . $countTotalEmail . ', please try ' . $sum . ' emails']);
            }

            if ($countTotalEmail + count($filteredData) > auth()->user()->credit) {
                $sum = auth()->user()->credit - $countTotalEmail;
                return response()->json(['status' => 201, 'msg' => 'Please try ' . $sum . ' more emails limit']);
            }

            $this->createUpdate(count($filteredData));
        }

        $userID = auth()->user()->id;

        $arr = FileUploads::create([
            'userID' => $userID,
            'name' => $request->file('file')->getClientOriginalName(),
            'file_title' => ($file_title ? json_encode($file_title) : false),
        ]);

        $batch = Bus::batch([])->dispatch();
        foreach ($filteredData as $key => $value) {
            if ($file_title && $key == 0) {
            } else {
                $full_data = json_encode($value);
               /*  $job = new EmailCleaner($arr->id, $value[$email_column], date('d-m-Y H:i:s'), auth()->user()->id, $full_data);
                dispatch($job); */
                // Retrieve the last inserted ID after the job is dispatched
                $batch->add(new EmailCleaner($arr->id, $value[$email_column], date('d-m-Y H:i:s'), auth()->user()->id, $full_data));
                $lastInsertedId = DB::getPdo()->lastInsertId();
                // dump($lastInsertedId);
                $return = [];
                EmailTotalList::create([
                    'userID' => $userID,
                    'file_uploads_id' => $arr->id,
                    'email' => $value[$email_column],
                    'queue_id' => $lastInsertedId,
                ]);
            }
        }
        $file = FileUploads::find($arr->id);
        $file->batch_id = $batch->id;
        $file->save();

        return response()->json(['status' => 200, 'msg' => trans('site.msg.upload'), 'url' => route('FinishedView')]);
    }

    public function FinishedView()
    {
        addVendors(['datatables', 'finishedView']);
        return view('dashboard.finished-list', ['title' => 'Finished List']);
    }

    public function FinishedDtatable(Request $request)
    {

        if ($request->ajax()) {
            if (auth()->user()->role == 'admin') {
                $data = FileUploads::latest()->get();
            } else {
                $data = FileUploads::where('userID', auth()->user()->id)->latest()->get();
            }
            return Datatables::of($data)->addIndexColumn()

                ->addColumn('processed', function ($row) {

                    $EmailTotalList = EmailTotalList::where('file_uploads_id', $row->id)->count();

                    $lastValidEmail = EmailFinishedList::where('file_uploads_id', $row->id)->count();
                    
                    if($EmailTotalList == $lastValidEmail) 
                    {
                        return '<span class="badge lh-sm bg-success">Complete</span>';
                        
                    } else {
                        return '<span class="badge lh-sm bg-info">Cleaning...</span>';
                    }
                })

                ->addColumn('fdate', function ($row) {
                    return $row->created_at->format('d-m-Y H:i:s A');
                })

                ->addColumn('total_clean_status', function ($row) {
                    // $EmailTotalList = EmailTotalList::where('file_uploads_id', $row->id)->where('queue_id', '=', '')->count();

                    $EmailTotalList = EmailFinishedList::where('file_uploads_id', $row->id)->where('userID', $row->userID)->count();
                    return '<span class="badge lh-sm bg-success">' . $EmailTotalList . '</span>';
                })

                ->addColumn('clean', function ($row) {
                    return '<span class="badge lh-sm bg-success">' . EmailFinishedList::where('file_uploads_id', $row->id)->where('status', 'Valid')->count() . '</span>';
                })
                
                ->addColumn('invalid', function ($row) {
                    return '<span class="badge lh-sm bg-success">' . EmailFinishedList::where('file_uploads_id', $row->id)->where('status', 'Invalid')->count() . '</span>';
                })

                ->addColumn('total', function ($row) {
                    return '<span class="badge lh-sm bg-primary">' . EmailTotalList::where('file_uploads_id', $row->id)->count() . '</span>';
                })

                ->addColumn('action', function ($row) {
                    $data = 'data-bs-toggle="modal" data-id="' . $row->id . '"  data-urlResponders="' . route('getAutoResponders') . '" data-bs-target="#AutoResponders"';
                    return '<div class="btn-group btn-group-sm">
                                    <a href="javascript::vaid" class="bg-light-success border-0 p-1 px-2 rounded ms-2 pushAutoResponders GetAutoRespondersOnclick rounded" ' . $data . '>
                                          ' . trans('site.curd-name.push') . ' <i class="bi bi-layer-forward"></i>
                                    </a>

                                    <a href="' . URL::to('admin/finished/clean-details/' . $row->id) . '" class="bg-light-info border-0 p-1 px-2 rounded ms-2 ">
                                    ' . trans('site.curd-name.view') . ' <i class="bi bi-file-earmark-break-fill"></i>
                                    </a>

                                    <button type="button" id="' . $row->id . '" class="badge fw-normal bg-light-red border-0 ms-2 rounded  data-delete ">
                                    ' . trans('site.curd-name.delete') . ' <i class="bi bi-trash-fill"></i>
                                    </button>
                            </div>';
                })

                ->rawColumns(['processed', 'fdate', 'total_clean_status', 'clean', 'total', 'action', 'invalid'])
                ->make(true);
        }
    }

    public function AllCounters($id)
    {
        $fileUpload = FileUploads::where('id', $id)->first();
        
        $EmailTotalList = EmailTotalList::where('file_uploads_id', $id)->count();

        return [
            'row' => $id ?? '',
            'date' => $fileUpload->created_at->format('jS M, Y') ?? '',
            'Total_Emails' => $EmailTotalList ?? '',
            'Clean' => EmailFinishedList::where('file_uploads_id', $id)->where('status', 'Valid')->count(),
            'Bounce' => EmailFinishedList::where('file_uploads_id', $id)->where('status', 'Bounce')->count(),
            'Invalid_Format' => EmailFinishedList::where('file_uploads_id', $id)->where('status', 'Invalid Email')->count(),
            'Invalid' => EmailFinishedList::where('file_uploads_id', $id)->where('status', 'Invalid')->count(),
            'Disposable' => EmailFinishedList::where('file_uploads_id', $id)->where('status', 'disposable')->count(),
            'Bad_MX' => EmailFinishedList::where('file_uploads_id', $id)->where('status', 'BadMX')->count(),
            'No_replies' => EmailFinishedList::where('file_uploads_id', $id)->where('status', 'no-reply')->count(),
            'Role_Based' => EmailFinishedList::where('file_uploads_id', $id)->where('status', 'role-base')->count(),
            'Suspected' => EmailFinishedList::where('file_uploads_id', $id)->where('status', 'Suspected Email')->count(),
            'invalid_domain' => EmailFinishedList::where('file_uploads_id', $id)->where('status', 'Invalid Domain')->count(),
        ];
    }

    public function CleanDetails($id)
    {
        addVendors(['downloadCsv']);
        return view('dashboard.clean-details-list', ['title' => 'Clean Details', 'data' => $this->AllCounters($id)]);
    }

    public function downloadCsv(Request $request)
    {
            // dd($request->all());
        foreach ($request->data as $val) {
            $rows = EmailFinishedList::select('name', 'email', 'status', 'full_data')->where('file_uploads_id', $request->rowID)->where('status', "$val")->get()->toArray();
            $rows_ = array_map(function ($data) {return json_decode($data['full_data'], true);}, $rows);
            $data[$val == 'Invalid Email' ? 'Invalid_Format' : $val] = $rows_;
        }

        $file = FileUploads::find($request->rowID);

        // Create a new zip archive
        $directoryPath = $csvFolderPath = public_path('zip_archive');
        $zip = new ZipArchive();
        $zipFilename = $directoryPath . '/contacts.zip';
        $zip->open($zipFilename, ZipArchive::CREATE | ZipArchive::OVERWRITE);

        // Check if the CSV folder exists, and create it if it doesn't
        if (!File::exists($csvFolderPath)) {
            File::makeDirectory($csvFolderPath, 0777, true);
        }
        // Loop through each data array and add it as a CSV file to the zip archive
        $x = 1;
        foreach ($data as $key => $dataArray) {
            $csvFilename = "{$directoryPath}/{$key}_{$x}$request->typeDownload";
            // Create a new CSV file for this data array
	    ob_clean();
            $handle = fopen($csvFilename, 'w');
            // fputcsv($handle, ['Name', 'Email', 'Status']);
            if (!empty($file->file_title)) {
                fputcsv($handle, json_decode($file->file_title));
            }
            foreach ($dataArray as $row) {
                fputcsv($handle, (array)$row);
            }
            fclose($handle);

            // Add the CSV file to the zip archive
            $zip->addFile($csvFilename, basename($csvFilename));

            // Add the directory path to the zip archive
            // $zip->addEmptyDir($directoryPath);
            $x++;
        }
        // Close the zip archive
        $zip->close();

        // Return the zip file as a download
        return response()->json(['status' => 200, 'zip' => asset('zip_archive/contacts.zip')]);
    }

    public function Delete(Request $request)
    {
        $ar = FileUploads::find($request->id);
        EmailFinishedList::where('file_uploads_id', $request->id)->delete();
        EmailTotalList::where('file_uploads_id', $request->id)->delete();
        $ar->delete();
    }

    public function chart(Request $request)
    {

        $Array = $this->AllCounters($request->rowID);
        unset($Array['Total_Emails']);
        unset($Array['row']);
        unset($Array['date']);

        $colors = [
            'rgba(75, 192, 192, 1)', // teal
            'rgba(255, 99, 132, 1)', // red
            'rgba(255, 205, 86, 1)', // yellow
            'rgba(54, 162, 235, 1)', // blue
            'rgba(255, 159, 64, 1)', // orange
            'rgba(153, 102, 255, 1)', // purple
            'rgba(255, 99, 255, 1)', // pink
            'rgba(100, 181, 246, 1)', // light blue
            'rgba(0, 204, 102, 1)', // green
            'rgba(255, 102, 102, 1)', // light red
            'rgba(102, 102, 102, 1)', // gray
            'rgba(245, 245, 245, 1)', // light gray
            'rgba(52, 73, 94, 1)', // dark gray
        ];

        $domain = EmailFinishedList::where('file_uploads_id', $request->rowID)->get()->toArray();
        $emails = [];
        foreach ($domain as $val) {
            $emails[] = $val['email'];
        }

        $domainArray = array_map('extractDomain', $emails);

        // Count occurrences of each domain name
        $domainCount = array_count_values($domainArray);

        // Output the resulting array of domain names and their counts

        $x = 0;
        foreach ($domainCount as $key => $value) {
            $tr2[] = ' <tr>
                        <td>
                            <p><i class="bi bi-square-fill" style="color: ' . $colors[$x] . ';"></i> ' . $key . ' </p>
                        </td>
                    <td><span class="badge bg-secondary">' . $value . '</span></td>
            </tr>';
            $x++;
        }

        $result = array_filter($Array, function ($value) {
            return $value !== 0;
        });

        $n = 0;
        foreach ($result as $key => $value) {
        if ($key == 'Clean') {
                $key = 'Valid';
            }
            $tr1[] = '<tr>
                        <td>
                            <p><i class="bi bi-square-fill" style="color: ' . $colors[$n] . ';"></i> ' . $key . ' </p>
                            </td>
                        <td><span class="badge bg-secondary">' . $value . '</span></td>
                    </tr>';
            $n++;
        }

        // pre($Array);
        return response()->json(
            [
                'colors' => $colors,
                'labels' => array_keys($result),
                'data' => array_values($result),
                'domainsName' => array_keys($domainCount),
                'domainsValue' => array_values($domainCount),
                'tr1' => $tr1,
                'tr' => $tr2,
            ],
        );
    }

    public function checkQueueProgress()
    {
        $queueSize = DB::table('jobs')->where('id', 1535)->count();
        pre($queueSize);
    }

    private function csv_title($data)
    {
        $csv_title = [];
        foreach ($data as $key => $value) {
            if (is_array($value)) {
                foreach ($value as $skey => $svalue) {
                    if (is_array($svalue)) {
                        $csv_title = array_merge($csv_title, array_keys($svalue));
                    }
                }
            }
        }
        return array_unique($csv_title);
    }

    public function restartQueue($id) {
        $code = Artisan::call('queue:retry-batch', ['id' => $id]);

        return response()->json(['status' => 200, 'msg' => 'cleaning...', ]);


    }
}
