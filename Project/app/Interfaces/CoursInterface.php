<?php

namespace App\Interfaces;

interface CoursInterface
{
    //
    public function create($data);
    public function show();
    public function destroy($id);
    public function update($request, $id);
}
