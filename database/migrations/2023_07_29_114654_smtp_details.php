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
        Schema::create('smtp_details', function (Blueprint $table) {
            $table->id();
            $table->string('username')->nullable();
            $table->string('smtp_host')->nullable();
            $table->string('smtp_port')->nullable();
            $table->string('driver')->nullable();
            $table->string('encryption')->nullable();
            $table->string('smtp_from_email')->nullable();
            $table->string('smtp_from_name')->nullable();
            $table->string('smtp_pass')->nullable();
            $table->string('awsAccessKey')->nullable();
            $table->string('awsSecretKey')->nullable();
            $table->string('awsDefaultRegion')->nullable();
            $table->string('awsBucket')->nullable();
            $table->string('awsPathStyle')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('smtp_details');
    }
};
