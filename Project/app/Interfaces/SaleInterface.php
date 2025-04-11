<?php

namespace App\Interfaces;

interface SaleInterface
{
    //
    public function addSale();
    public function store(array $data, $id);
    public function show();
    public function showSale($id);
    public function update($request, $id);
    public function destroy($id);
    public function getClients();
    public function getProducts();
    public function saleSearch(string $query);
    
}
