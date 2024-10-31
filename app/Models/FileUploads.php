<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FileUploads extends Model
{
    use HasFactory;

    protected $table = 'file_uploads';
    protected $primaryKey = 'id';
    protected $fillable = [
        'userID',
        'name',
        'file_title'
    ];

    public function ValidEmail()
    {
        return $this->belongsTo(EmailFinishedList::class, 'id', 'file_uploads_id')->withDefault();
    }

    public function EmailTotal()
    {
        return $this->belongsTo(EmailTotalList::class, 'id', 'file_uploads_id')->withDefault();
    }

}
