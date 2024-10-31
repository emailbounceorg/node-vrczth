<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Settings;

class SettingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Settings::create([
            'razorpay_on_off' => '',
            'razorpay_key' => '',
            'razorpay_secret' => '',
            'paypal_on_off' => '',
            'paypal_type' => '',
            'paypal_client_id' => '',
            'paypal_client_secret' => '',
            'stripe_on_off' => '',
            'stripe_client_id' => '',
            'stripe_client_secret' => '',
            'google_on_off' => '',
            'google_client_id' => '',
            'google_secret' => '',
            'helpEmail' => '',
            'emailCleaner' => '',
            'freeMail' => '0',
            'favicon' => '',
            'logo' => '',
            'version' => '1.3',
            'terms_and_conditions' => 'Terms and Conditions',
            'privacy_policy' => 'Privacy Policy',
        ]);
    }
}
