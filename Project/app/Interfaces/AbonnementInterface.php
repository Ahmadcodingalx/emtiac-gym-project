<?php

namespace App\Interfaces;

interface AbonnementInterface
{
    //
    public function create_service($data);
    public function show_service();
    public function destroy_service($id);
    public function update_service($request, $id);
}
