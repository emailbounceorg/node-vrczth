<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VerifyEmails extends Model
{
    use HasFactory;

    protected $table = 'verify_email_frontend';
    protected $primaryKey = 'id';
    protected $fillable = [
        'ip',
        'total',
        'date',
    ];
}
