<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Type extends Model
{
    //
    protected $fillable = [
        'name',
        'description',
        'type',
        'number',
        'amount',
    ];
}
