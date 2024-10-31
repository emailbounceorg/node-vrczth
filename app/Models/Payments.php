<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payments extends Model
{
    use HasFactory;
    protected $table = 'payments';
    protected $primaryKey = 'id';
    protected $fillable = [
        'userID',
        'type',
        'pay_id',
        'credit',
        'amt',
    ];

    protected $casts = [
        'created_at'  => 'date:d-m-Y h:i:s A',
    ];

    public function GetUser()
    {
        return $this->belongsTo(User::class, 'id', 'userID')->withDefault();
    }



}
