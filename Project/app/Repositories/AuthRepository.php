<?php

namespace App\Repositories;

use App\Interfaces\AuthInterface;
use App\Mail\OtpCodeEmail;
use App\Models\Abonnement;
use App\Models\OtpCode;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
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

        if (!$otp_code)
            return false;

        if (Hash::check($data['code'], $otp_code['code'])) {

            $user = User::where('email', $data['email'])->first();
            $user->password = $data['password'];
            $user->save();

            $otp_code->delete();

            // $user->token = $user->createToken($user->id)->plainTextToken;
            return true;
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
}
