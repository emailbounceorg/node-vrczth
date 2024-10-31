<?php

namespace Database\Seeders;

use App\Models\SMTPDetails;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SmtpSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        SMTPDetails::create([
            'username' => '',
            'smtp_host' => '',
            'smtp_port' => '',
            'driver' => '',
            'encryption' => '',
            'smtp_from_email' => '',
            'smtp_from_name' => '',
            'smtp_pass' => '',
            'awsAccessKey' => '',
            'awsSecretKey' => '',
            'awsDefaultRegion' => '',
            'awsBucket' => '',
            'awsPathStyle' => '',
        ]);
    }
}
