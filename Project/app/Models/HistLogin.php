<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HistLogin extends Model
{
    //
    protected $fillable = [
        'date',
        'username',
        'firstname',
        'lastname',
    ];
}
