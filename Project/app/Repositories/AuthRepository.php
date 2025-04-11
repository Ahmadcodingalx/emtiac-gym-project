<?php

namespace App\Repositories;

use App\Interfaces\AuthInterface;
use App\Mail\EmailNotification;
use App\Mail\OtpCodeEmail;
use App\Models\Abonnement;
use App\Models\HistLogin;
use App\Models\OtpCode;
use App\Models\User;
use App\Services\GeoIpService;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;

class AuthRepository implements AuthInterface
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }

    public function checkOtpCode($data)
    {
        // Logique pour vérifier le code OTP
        $otp_code = OtpCode::where('email', $data['email'])->first();

        if (!$otp_code) {
            return false;
        } else {
            if (Hash::check($data['code'], $otp_code['code'])) {

                $user = User::where('email', $data['email'])->first();
                $user->password = $data['password'];
                $user->save();
    
                $otp_code->delete();
    
                // $user->token = $user->createToken($user->id)->plainTextToken;
                return true;
            }
        }
        
        return false;
    }

    public function sendOtpEmail($email)
    {
        $user = User::where('email', $email)->first();

        if (!$user) {
            return false;
        } else {
            $otp_code = [
                'email' => $user->email,
                'code' => rand(100000, 999999)
            ];
    
            OtpCode::where('email', $user->email)->delete();
            OtpCode::create($otp_code);
            Mail::to($user->email)->send(
                new OtpCodeEmail(
                    $otp_code['code']
                )
            );
            return true;
        }
    }

    public function histLogin($id, $user)
    {
            // Récupère l'IP de l'utilisateur (utilise 'X-Forwarded-For' pour les proxys si possible)
        // $ipAddress = request()->header('X-Forwarded-For') ?? request()->ip();
        $ipAddress = file_get_contents('http://ipinfo.io/ip');
        
        // Envoie une requête à l'API ip-api pour obtenir les informations géographiques
        $response = Http::get("http://ip-api.com/json/{$ipAddress}")->json();

        $data = $response;
        $city = $data['city'] ?? 'Unknown';
        $region = $data['regionName'] ?? 'Unknown';
        $country = $data['country'] ?? 'Unknown';
        $latitude = $data['lat'] ?? 0;
        $longitude = $data['lon'] ?? 0;

        // Récupère les informations du user-agent
        $userAgent = request()->userAgent();

        // Prépare les données à enregistrer dans la base de données
        $data = [
            'user_id' => $id,
            'IpAddress' => $ipAddress,
            'country'    => $country,
            'city'       => $city,
            'region'     => $region,
            'latitude'   => $latitude,
            'longitude'  => $longitude,
            'user_agent' => $userAgent ?? 'unknown',
        ];

        $notif = 'Nouvelle connexion à Gym H, si ce n\'est pas vous, veuillez changer votre mot de passe';

        Mail::to($user->email)->send(
            new EmailNotification(
                $notif
            )
        );

        $admins = User::where('is_admin', true)->get();
        foreach ($admins as $admin) {
            if ($user->email != $admin->email) {
                $admin_notif = $user->lastname 
                            . ' '
                            . $user->firstname 
                            . ' vient de se connecter à Gym H.';

                Mail::to($admin->email)->send(
                    new EmailNotification(
                        $admin_notif
                    )
                );
            }
        }

        return HistLogin::create($data);
    }
}
