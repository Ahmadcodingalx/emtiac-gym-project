<?php

namespace App\Repositories;

use App\Interfaces\ProductInterface;
use App\Models\Product;
use Symfony\Component\Asset\PackageInterface;

class ProductRepository implements ProductInterface
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }

      
    public function create(array $data): Product
    {
        return Product::create($data);
    }

    public function show()
    {
        return Product::paginate(10);
        // return User::all();
    }

    public function viewProduct($id)
    {
        return Product::find($id);
    }

    public function update($productRequest)
    {
        $product = Product::findOrFail($productRequest->id);

        $product->name = $productRequest->input('name');
        $product->price = $productRequest->input('price');
        // $product->image = $productRequest->input('image');
        $product->quantity = $productRequest->input('quantity');
        $product->description = $productRequest->input('desc');
        
        // $product->updated_at = now();
        
        $product->save();

        return $product;
    }

    public function destroy($id)
    {
        return Product::find($id);
    }
}
