<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductSale extends Model
{
    //

    protected $fillable = [
        'sale_id',
        'product_id',
        'quantity',
        'subtotal',
    ];

    public function sale()
    {
        // Un client a plusieurs ventes
        return $this->belongsTo(Sale::class);
    }
}
