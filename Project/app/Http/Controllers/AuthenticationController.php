<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AuthenticationController extends Controller
{

    Public function login(Request $request) {

        $email_username = $request->email_username;
        $password = $request->password;

        if ($email_username == "ahmad" && $password == "1234") {
            // return redirect()->route('index')->with('success', 'connexion reussie');
            return view('dashboard/index');
        } else {
            return back()->with('error', ' Les infos ne sont pas valide');
        }

    }

    Public function create() {}

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
