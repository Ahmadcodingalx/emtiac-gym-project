<?php

namespace App\Interfaces;

use App\Models\User;

interface UserInterface
{
    //

    public function create(array $data): User;
    public function show();
    public function usersHistList();
    public function update($userRequest, $id);
    public function changePassword($passwordUpdateRequest, $id);
    public function rolesAssigned($id, $roleType);
    public function destroy($id);
    public function histLoginSearch(string $query);
    public function usersSearch(string $query);
}
