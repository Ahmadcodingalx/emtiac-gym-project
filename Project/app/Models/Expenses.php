<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Expenses extends Model
{
    //
    protected $fillable = [
        'user_id',
        'type', 
        'amount', 
        'reason', 
        'date', 
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
