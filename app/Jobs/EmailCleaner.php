<?php

namespace App\Jobs;

use App\Library\verifyEmail;
use App\Models\EmailFinishedList;
use App\Models\EmailTotalList;
use App\Models\Settings;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Config;
use Illuminate\Bus\Batchable;

class EmailCleaner implements ShouldQueue
{
    use Batchable, Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $id, $emails, $dateTimes, $UserID, $full_data;

    /**
     * Create a new job instance.
     */
    public function __construct($id, $emails, $dateTimes, $UserID, $full_data)
    {
        $this->id = $id;
        $this->emails = $emails;
        $this->dateTimes = $dateTimes;
        $this->UserID = $UserID;
        $this->full_data = $full_data;

        $arraySettings = Settings::latest()->first();
        $timezone = User::select('timezones')->where('id', $this->UserID)->latest()->first();
        $timezone = (!empty($timezone->timezones)) ? $timezone->timezones : $arraySettings->timezones;
        Config::set('app.timezone', $timezone);
        date_default_timezone_set($timezone);
    }

    /**
     * Execute the job.
     */

    public function handle(): void
    {
        $queueIDUpdate = EmailTotalList::where('email', $this->emails)->first();
        if ($queueIDUpdate->email ?? '' == $this->emails) {
            $queueIDUpdate->queue_id = '';
            $queueIDUpdate->save();
        }

        $arraySettings = Settings::latest()->first();
        // noReplyArray
        $noReply = noReplyArray([$this->emails]);
        foreach ($noReply as $value) {
            $this->SaveEmailList($this->UserID, $this->id, $value, $this->dateTimes, 'no-reply', $this->full_data);
        }

        // DisposableArray
        $Disposable = DisposableArray([$this->emails]);
        foreach ($Disposable as $value) {
            $this->SaveEmailList($this->UserID, $this->id, $value, $this->dateTimes, 'disposable', $this->full_data);
        }

        // roleBaseArray
        $roleBase = roleBaseArray([$this->emails]);
        foreach ($roleBase as $value) {
            $this->SaveEmailList($this->UserID, $this->id, $value, $this->dateTimes, 'role-base', $this->full_data);
        }

        // validEmailArray
        $email = validEmailArray([$this->emails]);
        foreach ($email as $value) {
            $verify = new verifyEmail();
            $verify->setStreamTimeoutWait(0);
            $verify->Debug = false;
            $verify->setEmailFrom($arraySettings->emailCleaner ?? '');
            $verify_email = $verify->check($value);

            $this->SaveEmailList($this->UserID, $this->id, $value, $this->dateTimes, $verify_email, $this->full_data);
            sleep(1);
        }
    }

    public function SaveEmailList($userID, $file_uploads_id, $email, $processed_on, $status, $full_data)
    {
        $data = [
            'userID' => $userID,
            'file_uploads_id' => $file_uploads_id,
            'email' => $email,
            'name' => '',
            'processed_on' => $processed_on,
            'finish_date' => date('d-m-Y H:i:s A'),
            'status' => $status,
            'full_data' => $full_data,

        ];
        // dd($data);
        EmailFinishedList::create($data);
    }
}
