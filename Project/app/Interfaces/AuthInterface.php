<?php

namespace App\Interfaces;

interface AuthInterface
{
    //
    public function checkOtpCode($data);
    public function sendOtpEmail($email);
}
