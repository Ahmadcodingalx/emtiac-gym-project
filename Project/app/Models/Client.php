<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    //
    use HasFactory;


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

    public function sale()
    {
        // Une client a plusieurs ventes
        return $this->hasMany(related: Sale::class);
    }
}
