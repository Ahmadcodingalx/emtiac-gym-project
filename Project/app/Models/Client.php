<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    //

    protected $fillable = [
        'firstname',
        'lastname',
        'image',
        'email',
        'tel',
        'identifiant',
        'address',
        'sex',
        'user_id_create',
        'user_id_update',
    ];
}
