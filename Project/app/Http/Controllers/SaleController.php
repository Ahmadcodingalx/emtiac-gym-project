<?php

namespace App\Http\Controllers;

use App\Interfaces\SaleInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SaleController extends Controller
{
    //
    private SaleInterface $saleInterface;

    public function __construct(SaleInterface $sale_interface)
    {
        $this->saleInterface = $sale_interface;
    }

    
    public function addSale()
    {

        $allData = $this->saleInterface->addSale();
        
        $clients = $allData['clientData'];
        $products = $allData['productData'];

        return view('sales/addSale', compact('clients', 'products'));
    }

    
    public function salesList()
    {
        $sales = $this->saleInterface->show();

        return view('sales/salesList', compact('sales'));
    }

    public function store(Request $request)
    {
        $request->validate([
            // 'client' => 'required',
            'product' => 'required',
        ]);

        $data1 = [
            'client_id' => $request->client,
            'total' => 0
        ];

        DB::beginTransaction();

        try {
            $sale = $this->saleInterface->store($data1, 1);

            if ($sale) {
                $products = json_decode($request->products, true);

                foreach ($products as $prod) {
                    $data = [
                        'sale_id' => $sale->id,
                        'product_id' => $prod['product'],
                        'quantity' => $prod['quantity'],
                        'subtotal' => $prod['total'],
                    ];

                    $this->saleInterface->store($data, 2);
                }

                DB::commit();
                return back()->with('success', 'Oppération éffectuée avec succès !');
            } else {
                DB::rollback();
                return back()->withErrors(['error' => 'Oppération a échoué.']);
            }

        } catch (\Throwable $th) {
            DB::rollback();
            //throw $th;
            // return $th;
            return back()->withErrors(['error' => $th . 'Une erreur est survenue lors de l\'oppération.']);
        }
    }

    public function showSale($id)
    {
        $sale = $this->saleInterface->showSale($id);
        $clients = $this->saleInterface->getClients();
        $products = $this->saleInterface->getProducts();

        return view('sales/showSale', compact('sale', 'clients', 'products'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'client' => 'exists:clients,id',
            'products' => 'required|json',
        ]);

        DB::beginTransaction();

        try {
            DB::commit();

            $sale = $this->saleInterface->update($request, $id);

            if ($sale) {
                return back()->with('success', 'Oppération éffectuée avec succès !');
            }
        } catch (\Throwable $th) {
            DB::rollback();
            //throw $th;
            // return $th;
            return back()->withErrors(['error' => $th . 'Une erreur est survenue lors de l\'oppération.']);
        }
    }
}
