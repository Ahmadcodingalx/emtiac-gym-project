<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HistLogin extends Model
{
    //
    protected $fillable = [
        'user_id',
        'IpAddress',
        'country',
        'region',
        'city',
        'latitude',
        'longitude',
        'user_agent',
    ];

    
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
