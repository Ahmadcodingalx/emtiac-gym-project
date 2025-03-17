<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthenticationController extends Controller
{

    Public function login(Request $request) 
    {
        $request->validate([
            'username' => 'required',
            'password' => 'required'
        ]);

        if (Auth::attempt(['username' => $request->username, 'password' => $request->password])) {

            // Récupérer l'utilisateur connecté
            $user = Auth::user();

            // Vérifier le rôle de l'utilisateur et rediriger en conséquence
            if ($user->is_admin == true) {
                // Rediriger vers le tableau de bord des administrateurs
                return redirect()->intended('/dashboard/index');
            } else {
                // Rediriger vers le tableau de bord des utilisateurs
                return redirect()->route('user.dashboard');
            }
        
        }

        return back()->withErrors(['username' => 'Identifiants incorrects.']);

    }

    Public function create() 
    {}

    public function forgotPassword()
    {
        return view('authentication/forgotPassword');
    }

    public function signIn()
    {
        return view('authentication/signIn');
    }

    public function signUp()
    {
        return view('authentication/signUp');
    }
}
