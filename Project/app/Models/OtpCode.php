<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class OtpCode extends Model
{
    use HasFactory, Notifiable;
    //
    protected $fillable = [
        'email',
        'code',
    ];

    protected function casts(): array
    {
        return [
            'code' => 'hashed',
        ];
    }
}
