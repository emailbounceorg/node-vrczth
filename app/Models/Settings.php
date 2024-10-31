<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Settings extends Model
{
    use HasFactory;
    protected $table = 'settings';
    protected $primaryKey = 'id';
    protected $fillable = [
        'razorpay_on_off',
        'razorpay_key',
        'razorpay_secret',
        'paypal_on_off',
        'paypal_type',
        'paypal_client_id',
        'paypal_client_secret',
        'stripe_on_off',
        'stripe_client_id',
        'stripe_client_secret',
        'google_on_off',
        'google_client_id',
        'google_secret',
        'helpEmail',
        'emailCleaner',
        'freeMail',
        'favicon',
        'logo',
        'version',
        'themes_color',
        'terms_and_conditions',
        'privacy_policy',
        'timezones',
        'address',
        'mobile',
        'default_credit_rate',
    ];
}
