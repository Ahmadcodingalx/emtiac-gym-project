<?php

namespace App\Interfaces;

use App\Models\Client;

interface ClientInterface
{
    //
    public function create(array $data): Client;
    public function show();
    public function viewClient($id);
    public function update($userRequest);
    public function destroy($id);
    public function clientSearch(string $query);
}
