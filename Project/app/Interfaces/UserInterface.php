<?php

namespace App\Interfaces;

use App\Models\User;

interface UserInterface
{
    //

    public function create(array $data): User;
    public function show();
    public function update($userRequest, $id);
    public function changePassword($passwordUpdateRequest, $id);
    public function destroy($id);
}
