<?php

namespace App\Http\Controllers;

use App\Http\Requests\PasswordUpdateRequest;
use App\Http\Requests\UserRequest;
use App\Interfaces\UserInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UsersController extends Controller
{

    private UserInterface $userInterface;

    public function __construct(UserInterface $userInterface)
    {
        $this->userInterface = $userInterface;
    }


    public function addUser()
    {
        return view('users/addUser');
    }
    
    public function usersGrid()
    {
        return view('users/usersGrid');
    }

    public function usersList()
    {
        $users = $this->userInterface->show();

        return view('users/usersList', compact('users'));
    }
    
    public function viewProfile()
    {
        return view('users/viewProfile');
    }

    public function create(UserRequest $userRequest)
    {
        // Validation des données
        $data = [
            'firstname' => $userRequest->firstname,
            'lastname' => $userRequest->lastname,
            'email' => $userRequest->email,
            'username' => 'user-' 
                        . strtoupper(substr($userRequest->firstname, 0, 2))
                        . '_'
                        . strtoupper(substr($userRequest->lastname, 0, 2))
                        . '_'
                        . rand(100, 999),
            'tel' => $userRequest->tel,
            'sex' => $userRequest->sex == 'Homme' ? true : false,
            'password' => rand(100000, 999999) 
                        . strtoupper(substr($userRequest->firstname, 0, 2))
                        . strtoupper(substr($userRequest->lastname, 0, 2)),
            'created_at' => now(),
            'image' => 'null',
            'address' => 'null',
            'is_admin' => false
        ];

        DB::beginTransaction();

        try {
            $user = $this->userInterface->create($data);
            
            if ($user) {  // Vérification si l'utilisateur a bien été créé
                DB::commit();
                return back()->with('success', 'Utilisateur créé avec succès !');
            } else {
                DB::rollback();
                return back()->withErrors(['error' => 'La création de l’utilisateur a échoué.']);
            }

        } catch (\Throwable $th) {
            DB::rollback();
            //throw $th;
            // return $th;
            return back()->withErrors(['error' => 'Une erreur est survenue lors de la création de l’utilisateur.']);
        }
    }

    public function update(UserRequest $userRequest)
    {

        DB::beginTransaction();
        $id = 0;

        try {
            $user = $this->userInterface->update($userRequest, $id);
            
            if ($user) {  // Vérification si l'utilisateur a bien été modifier
                DB::commit();
                return back()->with('success', 'Oppération réussie !');
            } else {
                DB::rollback();
                return back()->withErrors(['error' => 'Echec de l\'oppération.']);
            }

        } catch (\Throwable $th) {
            DB::rollback();
            //throw $th;
            // return $th;
            return back()->withErrors(['error' => $th . 'Une erreur est survenue lors de l\'oppération']);
        }
    }

    public function changePassword(PasswordUpdateRequest $passwordUpdateRequest)
    {

        DB::beginTransaction();
        $id = 0;

        try {
            $password = $this->userInterface->changePassword($passwordUpdateRequest, $id);
            
            if ($password) {  // Vérification si l'utilisateur a bien été modifier
                DB::commit();
                return back()->with('success', 'Oppération réussie !');
            } else {
                DB::rollback();
                return back()->withErrors(['error' => 'Ancien mot de passe incorrect !']);
            }

        } catch (\Throwable $th) {
            DB::rollback();
            //throw $th;
            // return $th;
            return back()->withErrors(['error' => $th . 'Une erreur est survenue lors de l\'oppération']);
        }
    }

    public function destroy(Request $request)
    {
        $id = $request->input('id');

        $user = $this->userInterface->destroy($id);
        $user->delete();

        return back()->with('success', 'Oppération réussie !');
    }
}
