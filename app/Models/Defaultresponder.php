<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Defaultresponder extends Model
{
    protected $fillable = [
        'user_id',
        'responder_id',
        'responder_list_id'
    ];
}
