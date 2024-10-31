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
        Schema::create('email_finished_list', function (Blueprint $table) {
            $table->id();
            $table->integer('userID');
            $table->integer('file_uploads_id');
            $table->string('email');
            $table->string('processed_on');
            $table->string('finish_date');
            $table->string('status')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('email_finished_list');
    }
};
