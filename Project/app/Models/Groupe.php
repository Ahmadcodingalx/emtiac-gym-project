<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Groupe extends Model
{
    //
    use HasFactory;

    protected $fillable = [
        'abonnement_id',
        'firstname',
        'lastname',
        'tel',
        'sex',
    ];

    public function abonnement()
    {
        return $this->belongsTo(Abonnement::class, 'abonnement_id');
    }
}
