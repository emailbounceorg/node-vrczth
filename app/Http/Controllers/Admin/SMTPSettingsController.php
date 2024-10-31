<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Mail\SendEmail;
use App\Models\SMTPDetails;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Http\Requests\SMTPRequest;
use App\Http\Requests\AWSRequest;

class SMTPSettingsController extends Controller
{
    public function __construct()
    {
        globalDashboardAssets();
    }


    public function index()
    {
        addVendors(['smtp-settings']);
        $smtp = SMTPDetails::first();
        return view('dashboard.smtp-settings', ['title'=> 'SMTP Settings', 'smtp'=>$smtp]);
    }

    public function UpdateSMTP(SMTPRequest $request){
        $request->validated();
        SMTPDetails::updateOrCreate(
            [
                'id'   => $request->id ?? '',
            ],
            $request->all(),
        );

        return response()->json(['status' => 200, 'msg' => 'SMTP Updated successfully']);
    }

    public function UpdateAWS(AWSRequest $request){
        $request->validated();
        SMTPDetails::updateOrCreate(
            [
                'id'   => $request->id ?? '',
            ],
            $request->all(),
        );

        return response()->json(['status' => 200, 'msg' => 'AWS Updated successfully']);
    }

    public function testEmail(Request $request){
        $validate = $request->validate(['emailTest' => 'required|email']);
        if(empty($request->emailTest)){
            return response()->json(['status' => 201]);
        }else{
            Mail::to($request->emailTest)->send(new SendEmail());
            return response()->json(['status' => 200]);
        }
    }
}
