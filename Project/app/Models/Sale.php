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
        // Un client a plusieurs ventes
        return $this->belongsTo(Client::class);
    }

    public function products()
    {
        return $this->belongsToMany(Product::class, 'product_sales', 'sale_id', 'product_id')
            ->withPivot('quantity', 'subtotal'); // Charger les colonnes pivot
    }
}
