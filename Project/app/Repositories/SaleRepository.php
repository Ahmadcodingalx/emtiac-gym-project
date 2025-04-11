<?php

namespace App\Repositories;

use App\Interfaces\SaleInterface;
use App\Models\Client;
use App\Models\Income;
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

            $transData = [
                'user_id' => auth()->id(),
                'sale_id' => $sale->id,
                'type' => 'sale',
                'date' => now(),
                'amount' => $sale->total,
                'reason' => 'Vente',
            ];
            $this->transaction_income($transData);

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

        /* Option 1 */
        // $oldProdQtt = ProductSale::where('sale_id', $sale->id)
        //     ->get() // Récupère les données
        //     ->map(fn($prodSale) => [ // Transforme chaque élément
        //         'id' => $prodSale->product_id,
        //         'qtt' => $prodSale->quantity,
        //     ])
        //     ->toArray(); // Convertit le résultat en tableau

        /* Option 2 */
        $oldProdQtt = ProductSale::where('sale_id', $sale->id)
            ->get()
            ->mapWithKeys(fn($prodSale) => [ 
                $prodSale->product_id => $prodSale->quantity
            ]) // Crée un tableau associatif où la clé est product_id et la valeur est qtt.
            ->toArray();

        //  Permet d’accéder directement à la quantité du produit sans boucle.
        // $productId = 5;
        // $qtt = $oldProdQtt[$productId] ?? null; 

        ProductSale::where('sale_id', $sale->id)->delete(); // Supprime tout en une seule requête

        // // Supprimer les anciens produits de la vente
        // $sale->products()->detach();

        // Ajouter les nouveaux produits
        $products = json_decode($request->products, true);

        foreach ($products as $prod) {
            $quantity = $oldProdQtt[$prod['product']];
            $data = [
                'sale_id' => $sale->id,
                'product_id' => $prod['product'],
                'quantity' => $prod['quantity'],
                'subtotal' => $prod['total'],
            ];

            ProductSale::create($data);

            $product = Product::find($data['product_id']);

            $product->quantity += $quantity;
            $product->quantity -= $data['quantity'];
            $product->save();

            $sale = Sale::find($data['sale_id']);
            $sale->total += $data['subtotal'];
            $sale->save();
        }

        // foreach ($products as $product) {
        //     $sale->products()->attach($product['product'], ['quantity' => $product['quantity'], 'total' => $product['total']]);
        // }

        return $sale;
    }
    public function destroy($id) {}

    public function saleSearch(string $query)
    {
        return Sale::with('client')
                    ->when($query, function ($q) use ($query) {
                        $q->where('created_at', 'LIKE', "%$query%")
                        ->orWhereHas('client', function ($uq) use ($query) {
                            $uq->where('firstname', 'LIKE', "%$query%")
                                ->orWhere('lastname', 'LIKE', "%$query%");
                        });
                    })
                    ->paginate(10);
    }

    public function transaction_income($data)
    {
        return Income::create($data);
    }
}
