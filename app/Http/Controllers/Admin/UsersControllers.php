<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use FontLib\Table\Type\name;
use Illuminate\Support\Facades\Validator;

class UsersControllers extends Controller
{
    public function __construct()
    {
        globalDashboardAssets();
    }

    public function index()
    {
        if (auth()->user()->role == 'user') {
            return redirect(route('home'));
        }

        addVendors(['datatables', 'users']);
        return view('dashboard.users-list', ['title' => 'Users List']);
    }

    public function UsersDatatable(Request $request)
    {
        if ($request->ajax()) {
            $data = User::latest()->get();
            return Datatables::of($data)->addIndexColumn()

                ->editColumn('role', function ($row) {
                    $color = $row->role == 'admin' ? 'light-primary' : 'light-secondary';
                    return '<span class="badge lh-sm bg-' . $color . '">' . $row->role . '</span>';
                })

                ->editColumn('credit', function ($row) {
                    return '<span class="badge lh-sm bg-light-success">' . $row->credit . '</span>';
                })

                ->addColumn('action', function ($row) {
                    $data = 'data-id="' . $row->id . '" data-name="' . $row->name . '" data-role="' . $row->role . '" data-email="' . $row->email . '" data-credit="' . $row->credit . '" ';
                    return '<div class="btn-group btn-group-sm">
                                    <a href="JavaScript:void(0)"  data-bs-toggle="modal" data-bs-target="#edit" ' . $data . ' class="fw-normal p-1 px-2 bg-light-white border edit-button rounded"  data-title="' . trans('site.curd-name.edit') . '" data-btn-text="' . trans('site.users.modal.button') . '">
                                    ' . trans('site.curd-name.edit') . ' <i class="bi bi-pencil-square"></i>
                                    </a>
                                    <button type="button" id="' . $row->id . '" class="fw-normal bg-light-red border-0 data-delete p-1 px-2 ms-2 rounded">
                                    ' . trans('site.curd-name.delete') . ' <i class="bi bi-trash-fill"></i>
                                    </button>
                            </div>';
                })
                ->rawColumns(['name', 'email', 'role', 'credit', 'action'])
                ->make(true);
        }
    }

    public function UserUpdate(Request $request)
    {
        $sanitizedData = array_map('sanitizeInput', $request->all());
        $validator = Validator::make($sanitizedData, [
            'name' => ['required'],
            'email' => ['required','email'],
            'credit' => ['numeric', 'nullable'],
            'password' => [
                'nullable',
                'string',
                'min:6',
            ],
        ]);


        if ($validator->fails()) {
            return response()->json(['status' => 201, 'errors' => $validator->errors(), 'msg' => $validator->errors()->first()]);
        }

        if (!empty($sanitizedData['id'])) {
            $user = User::find($sanitizedData['id']);
            $response = array(
                'status' => 200,
                'msg' => trans('site.msg.update'),
            );
        } else {
            $user = new User();
            $response = array(
                'status' => 200,
                'msg' => trans('site.msg.create'),
                'arPushEmailUrl' => route('responder.pushEmail'),
                'email' => $sanitizedData['email']
            );
        }

        $user->role = $sanitizedData['inlineRadioOptions'];
        $user->name = $sanitizedData['name'];
        $user->email = $sanitizedData['email'];
        if (!empty($sanitizedData['password'])) {
            $user->password = Hash::make($sanitizedData['password']);
        }
        $user->credit = $sanitizedData['credit'] ?? 0;
        $user->save();
        return response()->json($response);
    }

    public function Delete(Request $request)
    {
        User::where('id', $request->id)->delete();
    }
}
