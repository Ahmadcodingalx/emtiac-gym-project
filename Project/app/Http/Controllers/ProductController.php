<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductRequest;
use App\Interfaces\ProductInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    private ProductInterface $productInterface;

    public function __construct(ProductInterface $product)
    {
        $this->productInterface = $product;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    

    public function addProduct()
    {
        return view('product/addProduct');
    }

    public function productsList()
    {
        $products = $this->productInterface->show();

        return view('product/productList', compact('products'));
    }
    
    public function viewProduct($id)
    {
        $product = $this->productInterface->viewProduct($id);

        return view('product/viewProduct', compact('product'));
    }



    /**
     * Show the form for creating a new resource.
     */
    public function create(ProductRequest $productRequest)
    {
        $filePath = 'defaults/product.png';

        if ($productRequest->hasFile('image')) {

            $image = $productRequest->file('image');

            $image_ext = $image->getClientOriginalExtension();
            $image_name = 'Product_' . time() . '.' . $image_ext;
            $filePath = $image->storeAs('products', $image_name, 'public');
        }

        // Validation des données
        $data = [
            'name' => $productRequest->name,
            'price' => $productRequest->price,
            'quantity' => $productRequest->quantity,
            'description' => $productRequest->desc,
            'image' => $filePath,
        ];

        DB::beginTransaction();

        try {
            $product = $this->productInterface->create($data);
            
            if ($product) {  // Vérification si l'utilisateur a bien été créé
                DB::commit();
                return back()->with('success', 'Produit créé avec succès !');
            } else {
                DB::rollback();
                return back()->withErrors(['error' => 'La création du produit a échoué.']);
            }

        } catch (\Throwable $th) {
            DB::rollback();
            //throw $th;
            // return $th;
            return back()->withErrors(['error' => 'Une erreur est survenue lors de la création du produit.']);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ProductRequest $productRequest)
    {
        //
        DB::beginTransaction();
        $id = 0;

        try {
            $product = $this->productInterface->update($productRequest);
            
            if ($product) {  // Vérification si l'utilisateur a bien été modifier
                DB::commit();
                return back()->with('success', 'Oppération réussie !');
            } else {
                DB::rollback();
                return back()->withErrors(['error' => 'Echec de l\'oppération.']);
            }

        } catch (\Throwable $th) {
            DB::rollback();
            //throw $th;
            // return $th;
            return back()->withErrors(['error' => 'Une erreur est survenue lors de l\'oppération']);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        //

        $product = $this->productInterface->destroy($request->id);
        $product->delete();

        return back()->with('success', 'Oppération réussie !');
    }

        
    public function productSearch(Request $request)
    {
        $query = $request->get('q');
        $products = $this->productInterface->productSearch($query);

        return view('product.productTable', compact('products'))->render();
        
    }
    
    public function productSearchZero(Request $request)
    {

        $query = $request->get('q');
        $products = $this->productInterface->show();

        return view('product.productTable', compact('products'))->render();
    }
}
