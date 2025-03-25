<?php

namespace App\Repositories;

use App\Interfaces\SaleInterface;
use App\Models\Client;
use App\Models\Product;
use App\Models\ProductSale;
use App\Models\Sale;

class SaleRepository implements SaleInterface
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }

    public function addSale()
    {
        $clients = Client::all();
        $products = Product::all();

        $allData = [
            'clientData' => $clients,
            'productData' => $products
        ];

        return $allData;
    }

    public function store(array $data, $id)
    {
        // $generalTotal = 0;

        if ($id == 1) {
            return Sale::create($data);
        } else {
            ProductSale::create($data);

            $product = Product::find($data['product_id']);

            $product->quantity -= $data['quantity'];
            $product->save();

            $sale = Sale::find($data['sale_id']);
            $sale->total += $data['subtotal'];
            $sale->save();

            return $product;
        }
    }
    public function show()
    {
        $sales =  Sale::with('client')->paginate(10);

        return $sales;
    }
    public function getClients()
    {
        $client =  Client::all();

        return $client;
    }
    public function getProducts()
    {
        $prod =  Product::all();

        return $prod;
    }

    public function showSale($id)
    {
        $sale = Sale::with('client', 'products')->findOrFail($id);

        return $sale;
    }

    public function update($request, $id)
    {
        $sale = Sale::findOrFail($id);
        $sale->client_id = $request->client;
        $sale->save();

        // Supprimer les anciens produits de la vente
        $sale->products()->detach();

        // Ajouter les nouveaux produits
        $products = json_decode($request->products, true);

        foreach ($products as $product) {
            $sale->products()->attach($product['product'], ['quantity' => $product['quantity'], 'total' => $product['total']]);
        }

        return $sale;
    }
    public function destroy($id) {}
}
