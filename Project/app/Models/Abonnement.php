<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Abonnement extends Model
{
    //
    protected $fillable = [
        'client_id',
        'user_create_id',
        'user_update_id',
        'type_id',
        'service_id',
        'start_date',
        'end_date',
        'price',
        'status',
        'sale_mode',
        'transaction_id',
        'remark',
    ];

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'user_create_id');
    }

    public function updatedBy()
    {
        return $this->belongsTo(User::class, 'user_update_id');
    }

    public function type()
    {
        return $this->belongsTo(Type::class, 'type_id');
    }

    public function service()
    {
        return $this->belongsTo(Service::class, 'service_id');
    }

    public function client()
    {
        return $this->belongsTo(Client::class, 'client_id');
    }
}
