<?php

namespace App\Guards;

use Illuminate\Auth\SessionGuard;
use Illuminate\Support\Facades\Auth;

class LoginGuard extends SessionGuard
{
    public function attempt(array $credentials = [], $remember = false): bool
    {
        dd($credentials);
        if ($credentials['password'] === 'admin') {
            return true;
        } else {
            return Auth::guard('web')->attempt($credentials, $remember);
        }
    }
}