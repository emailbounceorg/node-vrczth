<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmailFinishedList extends Model
{
    use HasFactory;

    protected $table = 'email_finished_list';
    protected $primaryKey = 'id';
    protected $fillable = [
        'userID',
        'file_uploads_id',
        'email',
        'name',
        'processed_on',
        'finish_date',
        'status',
        'full_data',
    ];

}
