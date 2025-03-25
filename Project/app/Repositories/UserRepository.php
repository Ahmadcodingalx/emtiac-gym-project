<?php

namespace App\Repositories;

use App\Interfaces\UserInterface;
use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserRepository implements UserInterface
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }

    public function create(array $data): User
    {
        $user = User::create($data);

        if ($user) {
            $data = [
                'user_id' => $user->id
            ];
            Role::create($data);
        }

        return $user;
    }

    public function show()
    {
        return User::paginate(10);
        // return User::all();
    }

    public function update($userRequest, $id)
    {
        $user = User::findOrFail(auth()->id());

        if ($userRequest->input('username')) {
            $user->username = $userRequest->input('username');
            $user->firstname = $userRequest->input('firstname');
            $user->lastname = $userRequest->input('lastname');
            // $user->image = $userRequest->input('image');
            $user->email = $userRequest->input('email');
            $user->tel = $userRequest->input('tel');
            $user->address = $userRequest->input('address');
            $user->sex = $userRequest->input('sex') == "Homme" ? true : false;
        }

        $user->updated_at = now();
        
        $user->save();

        return $user;
    }

    public function changePassword($passwordUpdateRequest, $id)
    {
        $user = User::findOrFail(auth()->id());

        if ($passwordUpdateRequest->input('old_password')) {
            if (Hash::check($passwordUpdateRequest->input('old_password'), $user->password)) {
                $user->password = $passwordUpdateRequest->input('new_password');
            } else {
                return false;
            }
        }

        $user->updated_at = now();
        
        $user->save();

        return $user;
    }

    public function destroy($id)
    {
        return User::find($id);
    }

    public function rolesAssigned($id, $roleType)
    {
        $role = Role::where('user_id', $id)->first();

        switch ($roleType) {
            case 1:
                $role->coach = !$role->coach;
                break;
            
            case 2:
                $role->cashier = !$role->cashier;
                break;

            default:
                $role->secretary = !$role->secretary;
                break;
        }

        $role->save();

        return $role;
    }
}
