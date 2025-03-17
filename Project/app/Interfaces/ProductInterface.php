<?php

namespace App\Interfaces;

use App\Models\Product;

interface ProductInterface
{
    //
    public function create(array $data): Product;
    public function show();
    public function viewProduct($id);
    public function update($productRequest);
    public function destroy($request);
}
