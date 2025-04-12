<?php

namespace App\Repositories;

use App\Interfaces\ProductInterface;
use App\Models\Product;
use Illuminate\Support\Facades\Storage;
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

        if ($productRequest->hasFile('image')) {
            // Supprimer l'ancienne image si elle existe
            if ($product->image !== 'defaults/product.png' && Storage::disk('public')->exists($client->image)) {
                Storage::disk('public')->delete($product->image);
            }

            $image = $productRequest->file('image');

            $image_ext = $image->getClientOriginalExtension();
            $image_name = 'Product_' . time() . '.' . $image_ext;
            $product->image = $image->storeAs('products', $image_name, 'public');
        }
        
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
        $product = Product::find($id);
        if ($product->image !== 'defaults/profile.png' && Storage::disk('public')->exists($product->image)) {
            Storage::disk('public')->delete($product->image);
        }
        return $product;
    }

    public function productSearch($query)
    {
        return Product::when($query, function ($q) use ($query) {
            $q->where('name', 'LIKE', "%$query%")
            ->orWhere('created_at', 'LIKE', "%$query%");
        })
        ->paginate(10);
    }
}
