<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cours extends Model
{
    //

    protected $fillable = [
        'name',
        'description',
        'coach_id',
    ];
}
