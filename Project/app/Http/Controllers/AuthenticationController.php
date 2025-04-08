<?php

namespace App\Http\Controllers;

use App\Interfaces\AuthInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AuthenticationController extends Controller
{
    private AuthInterface $authInterface;

    public function __construct(AuthInterface $authInterface)
    {
        $this->authInterface = $authInterface;
    }

    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required',
            'password' => 'required'
        ]);

        if (Auth::attempt(['username' => $request->username, 'password' => $request->password])) {

            // Récupérer l'utilisateur connecté
            $user = Auth::user();

            // $this->authInterface->update_ab_status();

            // Vérifier le rôle de l'utilisateur et rediriger en conséquence
            if ($user->is_admin == true) {
                // Rediriger vers le tableau de bord des administrateurs
                return redirect()->intended('/dashboard/index');
            } else {
                // Rediriger vers le tableau de bord des utilisateurs
                return redirect()->route('transList');
            }
        }

        return back()->withErrors(['username' => 'Identifiants incorrects.']);
    }

    public function create() {}

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

    public function logout()
    {
        Auth::logout();  // Déconnecte l'utilisateur
        return redirect()->route('login');  // Redirige vers la page de connexion ou autre
    }


    //Fonction pour la vérification du code OTP
    public function checkOtpCode(Request $request)
    {
        $data = [
            'email' => $request->change_password_email,
            'code' => $request->otp_code,
            'password' => $request->new_access_key,
        ];
        dd($request->email);

        DB::beginTransaction();

        try {
            $user = $this->authInterface->checkOtpCode($data);

            if (!$user) {
                DB::commit();
                return back()->withErrors(['error' => 'Code OTP incorrect.']);
            }

            return back()->with('success', 'Réinitialisation réussie.');
        } catch (\Throwable $th) {
            //throw $th;
            // return $th;
            return back()->withErrors(['error' => $th . 'Une erreur est survenue lors de la création de l’utilisateur.']);
        }
    }

    //Fonction pour la vérification du code OTP
    public function sendOtpEmail(Request $request)
    {
        $data = [
            'email' => $request->email,
        ];

        DB::beginTransaction();

        try {
            $email = $this->authInterface->sendOtpEmail($data['email']);

            if (!$email) {
                return back()->withErrors(['error' => 'Cette email n\'est pas reconnue.']);
            } else {
                DB::commit();
                // puis tu rediriges AVEC les données de l'input :
                return redirect()->back()->withInput()->with('success', 'OTP envoyé avec succès !');
            }
        } catch (\Throwable $th) {
            //throw $th;
            // return $th;
            return back()->withErrors(['error' => $th . 'Une erreur est survenue lors de la création de l’utilisateur.']);
        }
    }
}
