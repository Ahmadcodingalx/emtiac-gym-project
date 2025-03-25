<?php

namespace App\Interfaces;

interface AbonnementInterface
{
    //
    public function addAb();
    public function show();
    public function viewAb($id);
    public function store($data);
    public function destroy($id);



    public function create_service($data);
    public function show_service();
    public function destroy_service($id);
    public function update_service($request, $id);
    //
    public function create_type($data);
    public function show_type();
    public function destroy_type($id);
    public function update_type($request, $id);
}
