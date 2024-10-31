<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->string('razorpay_on_off');
            $table->string('razorpay_key');
            $table->string('razorpay_secret');
            $table->string('paypal_on_off');
            $table->string('paypal_type');
            $table->string('paypal_client_id');
            $table->string('paypal_client_secret');
            $table->string('stripe_on_off');
            $table->string('stripe_client_id');
            $table->string('stripe_client_secret');
            $table->string('google_on_off');
            $table->string('google_client_id');
            $table->string('google_secret');
            $table->string('helpEmail');
            $table->string('emailCleaner');
            $table->string('freeMail');
            $table->string('favicon');
            $table->string('logo');
            $table->string('version');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('settings');
    }
};
