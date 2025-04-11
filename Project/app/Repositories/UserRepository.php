<?php

namespace App\Repositories;

use App\Interfaces\UserInterface;
use App\Mail\EmailNotification;
use App\Mail\OtpCodeEmail;
use App\Models\HistLogin;
use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;

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
            $data2 = [
                'user_id' => $user->id
            ];
            $notif = 'Votre compte Gym H, vient d\'être créé. 
                        Votre nom d\'utilisateur est : '
                        . $data['username']
                        . ' et votre mot de passe est : '
                        . $data['password'] 
                        . ' Utiliser ces informations pour vous connectez à Gym H';

            Mail::to($user->email)->send(
                new EmailNotification(
                    $notif
                )
            );

            $admins = User::where('is_admin', true)->get();
            foreach ($admins as $admin) {
                if ($user->email != $admin->email) {
                    $admin_notif = 'Le compte de ' 
                        . $data['lastname']
                        . ' '
                        . $data['firstname']
                        . ' est créé aveec succès, son nom d\'utilisateur : '
                        . $data['username']
                        . ' et son mot de passe est : '
                        . $data['password'] . '.';

                    Mail::to($admin->email)->send(
                        new EmailNotification(
                            $admin_notif
                        )
                    );
                }
            }
            Role::create($data2);
        }

        return $user;
    }

    public function show()
    {
        return User::paginate(10);
        // return User::all();
    }

    public function usersHistList()
    {
        return HistLogin::with('user')->paginate(10);
    }

    public function update($userRequest, $id)
    {
        $user = User::findOrFail(auth()->id());

        if ($userRequest->input('username')) {
            if ($userRequest->hasFile('image')) {
                // Supprimer l'ancienne image si elle existe
                if ($user->image !== 'defaults/profile.png' && Storage::disk('public')->exists($user->image)) {
                    Storage::disk('public')->delete($user->image);
                }

                $image = $userRequest->file('image');

                $image_ext = $image->getClientOriginalExtension();
                $image_name = 'User_' . time() . '.' . $image_ext;
                $user->image = $image->storeAs('users', $image_name, 'public');
            }

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
        $role = User::findOrFail($id);
        $check_is_super_admin = Role::where('user_id', $id)->first();

        if($check_is_super_admin) {
            $role->is_admin = !$role->is_admin;
            $role->save();

            return $role;
        } else {
            return false;
        }
        // $role = Role::where('user_id', $id)->first();

        // switch ($roleType) {
        //     case 1:
        //         $role->coach = !$role->coach;
        //         break;

        //     case 2:
        //         $role->cashier = !$role->cashier;
        //         break;

        //     default:
        //         $role->secretary = !$role->secretary;
        //         break;
        // }

        // $role->save();

    }

    public function histLoginSearch(string $query)
    {
        return HistLogin::with('user')
            ->when($query, function ($q) use ($query) {
                $q->where('created_at', 'LIKE', "%$query%")
                ->orWhereHas('user', function ($uq) use ($query) {
                    $uq->where('firstname', 'LIKE', "%$query%")
                        ->orWhere('lastname', 'LIKE', "%$query%");
                });
            })
            ->paginate(10);
    }

    public function usersSearch(string $query)
    {
        return User::when($query, function ($q) use ($query) {
                $q->where('firstname', 'LIKE', "%$query%")
                ->orWhere('lastname', 'LIKE', "%$query%")
                ->orWhere('username', 'LIKE', "%$query%")
                ->orWhere('email', 'LIKE', "%$query%")
                ->orWhere('tel', 'LIKE', "%$query%");
            })
            ->paginate(10);
    }
}
