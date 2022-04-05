<?php

namespace Authenticate\Facades;

use Illuminate\Support\Facades\Auth;

class BaseAuth
{

    public function check()
    {
        return Auth::check();
    }

    public function loginUsingId($uid)
    {
        $user = Auth::loginUsingId($uid);
        
        return $user->makeVisible(['api_token','role']);
    }

    public function logout()
    {
        return auth()->logout();
    }
}
