<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    //
    protected $fillable = [
        'name',
        'description',
        'quantity',
        'image',
        'price',
    ];

    public function sales()
    {
        return $this->belongsToMany(Sale::class, 'product_sales', 'product_id', 'sale_id')
            ->withPivot('quantity', 'subtotal');
    }
}
