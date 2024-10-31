<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FailedJob extends Model
{
    protected $table = "job_batches";
    protected $primary_key = 'id';

    protected $fillable = [
        
    ];
}