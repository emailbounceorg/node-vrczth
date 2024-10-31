<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\FileUploads;
use App\Models\Payments;
use App\Models\Responders;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Redirect;


class HomeController extends Controller
{
    public function __construct()
    {
        globalDashboardAssets();
    }

    public function userAnalysisChart()
    {
        // Retrieve user data
        $users = User::all();

        // Prepare data for analysis
        $roles = [];
        $userCountByRole = [];
        $userDates = [];

        foreach ($users as $user) {
            $role = $user->role;
            $createdDate = $user->created_at->format('Y-m-d'); // Assuming your User model has a 'created_at' timestamp field

            if (!in_array($role, $roles)) {
                $roles[] = $role;
                $userCountByRole[$role] = 0;
                $userDates[$role] = [];
            }

            $userCountByRole[$role]++;
            $userDates[$role][$createdDate] = isset($userDates[$role][$createdDate]) ? $userDates[$role][$createdDate] + 1 : 1;
        }

        // Pass the data to the view
        $userData = [
            'roles' => $roles,
            'userCountByRole' => $userCountByRole,
            'userDates' => $userDates,
        ];

        // Convert the data to JSON
        return json_encode($userData);
    }

    public  function index()
    {
        if (Auth::user()->role == 'admin') {
            $Payments = Payments::count();
            $Responders = Responders::count();
            $UploadFile = FileUploads::count();
        } else {
            $UploadFile = FileUploads::where('userID', Auth::user()->id)->count();
            $Responders = Responders::where('userID', Auth::user()->id)->count();
            $Payments = Payments::where('userID', Auth::user()->id)->count();
        }

        $data = [
            'CreditAvailable' => Auth::user()->credit,
            'UploadFile' => $UploadFile,
            'AutoResponders' => $Responders,
            'Payment' => $Payments,
            'userAnalysisChart' => $this->userAnalysisChart(),
        ];


        addVendors(['dashboard']);

        return view('dashboard.home', ['title' => 'Dashboard', 'data' => $data]);
    }

    public function paymentAnalysis()
    {
        return Payments::all();
    }

    public function switchLang($lang)
    {
        if (array_key_exists($lang, Config::get('languages'))) {
            Session::put('applocale', $lang);
        }
        return Redirect::back();
    }
}
