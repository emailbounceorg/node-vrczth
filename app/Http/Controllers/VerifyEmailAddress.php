<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Library\verifyEmail;
use App\Models\Settings;
use App\Models\VerifyEmails;
use Spatie\FlareClient\Http\Exceptions\InvalidData;

class VerifyEmailAddress extends Controller
{
    public function index(Request $request)
    {
        $mail = array_unique(preg_split('/\R+/', $request->mail, 0, PREG_SPLIT_NO_EMPTY));
        if (empty($mail)) {
            return response()->json(['status' => 201]);
        }
        $arraySettings = Settings::latest()->first();
        $emails = [];
        $InvalidEmail = [];
        foreach ($mail as $key => $value) {
            if (filter_var($value, FILTER_VALIDATE_EMAIL)) {
                $verify = new verifyEmail();
                $verify->setStreamTimeoutWait(0);
                $verify->Debug = FALSE;
                $verify->setEmailFrom($arraySettings->emailCleaner ?? '');
                $status = $verify->check($value);
                if ($status == 'Valid') {
                    $emails[] = $value;
                    continue;
                }
                $InvalidEmail[] = $value;
            }
            $InvalidEmail[] = $value;
            sleep(1);
        }
        return response()->json(['status' => 200, 'data' => implode("\n", $emails), 'InvalidEmail' => implode("\n", array_unique($InvalidEmail))]);
    }

    public function checkEmail(Request $request)
    {
        $arraySettings = Settings::latest()->first();
        if (filter_var($request->email, FILTER_VALIDATE_EMAIL)) {
            $verify = new verifyEmail();
            $verify->setStreamTimeoutWait(0);
            $verify->Debug = FALSE;
            $verify->setEmailFrom($arraySettings->emailCleaner ?? '');
            $status = $verify->check($request->email);
            if ($status == 'Valid') {
                return response()->json(['status' => 200, 'msg' => 'Valid Email!']);
            }
            $domain = explode('@', $request->email);
            return response()->json(['status' => 201, 'msg' => $status, 'domain'=>$domain[1]??'']);
        }
        return response()->json(['status' => 201, 'msg' => 'Invalid Format']);
    }


    public function VerifyEmail(Request $request)
    {
        $VerifyEmail = VerifyEmails::where(['ip' => $request->ip(), 'date' => date('Y-m-d')])->latest()->first();

        if (empty($VerifyEmail)) {
            $VerifyEmail = $this->saveCreate($request->ip(), 1);
        }else{
            $total = ($VerifyEmail->total + 1);
            $this->Update($request->ip(), $total);
        }

        if ( $VerifyEmail->date == date('Y-m-d') && 6 > $VerifyEmail->total ) {

            $arraySettings = Settings::latest()->first();
            if (!filter_var($request->CheckEmail, FILTER_VALIDATE_EMAIL)) {
                return response()->json(['status' => 201, 'msg' => 'Invalid Format']);
            }

            $verify = new verifyEmail();
            $verify->setStreamTimeoutWait(0);
            $verify->Debug = FALSE;
            $verify->setEmailFrom($arraySettings->emailCleaner ?? '');
            $status = $verify->check($request->CheckEmail);
            if ($status == 'Valid') {
                return response()->json(['status' => 200, 'msg' => 'Valid Email!']);
            }
            $domain = explode('@', $request->CheckEmail);
            return response()->json(['status' => 201, 'msg' => $status, 'domain'=>$domain[1]??'']);
        }

        return response()->json(['status' => 201, 'msg' => 'You have exceeded the test limit!']);
    }

    public function saveCreate($ip, $total)
    {
        return VerifyEmails::Create(
            [
                'ip' => $ip,
                'total' => $total,
                'date' => date('Y-m-d'),
            ],
        );
    }

    public function Update($ip, $total)
    {
        VerifyEmails::where([
            'ip' => $ip,
            'date' => date('Y-m-d'),
        ])->update([
            'ip' => $ip,
            'total' => $total,
        ]);
    }
}
