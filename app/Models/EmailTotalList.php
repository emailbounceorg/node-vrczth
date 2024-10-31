<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmailTotalList extends Model
{
    use HasFactory;
    protected $table = 'email_total_list';
    protected $primaryKey = 'id';
    protected $fillable = [
        'userID',
        'file_uploads_id',
        'email',
        'name',
        'queue_id',
    ];

}
