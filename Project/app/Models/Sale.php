<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    //
    use HasFactory;

    protected $fillable = [
        'client_id',
        'total',
    ];

    public function client()
    {
        return $this->belongsTo(Client::class, 'client_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function products()
    {
        return $this->belongsToMany(Product::class, 'product_sales', 'sale_id', 'product_id')
            ->withPivot('quantity', 'subtotal'); // Charger les colonnes pivot
    }

    public function incomes()
    {
        return $this->belongsTo(Income::class, 'sale_id');
    }

    public function Transactions()
    {
        return $this->belongsTo(Transaction::class, 'sale_id');
    }
}
