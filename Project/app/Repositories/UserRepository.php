<?php

namespace App\Repositories;

use App\Interfaces\UserInterface;
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
        return User::create($data);
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
}
