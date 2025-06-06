<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    //
    protected $fillable = [
        'user_id',
        'abb_id',
        'sale_id',
        'type', 
        'amount', 
        'reason', 
        'category', 
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function sale()
    {
        return $this->belongsTo(Sale::class);
    }

    public function abb()
    {
        return $this->belongsTo(Abonnement::class);
    }
}
