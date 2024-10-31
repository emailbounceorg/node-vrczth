<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SMTPDetails extends Model
{
    use HasFactory;
    protected $table = "smtp_details";

    protected $fillable = [
        "username",
        "smtp_host",
        "smtp_port",
        "smtp_from_email",
        "smtp_from_name",
        "driver",
        "encryption",
        "smtp_pass",
        "awsAccessKey",
        "awsSecretKey",
        "awsDefaultRegion",
        "awsBucket",
        "awsPathStyle",
    ];
}
