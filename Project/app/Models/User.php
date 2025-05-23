<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'is_admin',
        'username',
        'firstname',
        'lastname',
        'email',
        'tel',
        'image',
        'password',
        'address',
        'sex',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function createdAbonnements()
    {
        return $this->hasMany(Abonnement::class, 'user_create_id');
    }

    public function hist_logins()
    {
        return $this->hasMany(HistLogin::class, 'user_id');
    }

    public function updatedAbonnements()
    {
        return $this->hasMany(Abonnement::class, 'user_update_id');
    }

    public function incomes()
    {
        return $this->hasMany(Income::class, 'user_id');
    }

    public function expenses()
    {
        return $this->hasMany(Expenses::class, 'user_id');
    }

    public function Transactions()
    {
        return $this->hasMany(Transaction::class, 'user_id');
    }
}
