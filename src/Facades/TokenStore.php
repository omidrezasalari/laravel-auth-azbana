<?php

namespace Authenticate\Facades;


class TokenStore
{
    /**
     * Store token
     *
     * @param string $mobile user mobile number
     * @param string $token token generated
     *
     * @return void
     */
    public function store($mobile, $token)
    {
        $ttl = config('authenticate_config.token_ttl');
        cache()->set($token . 'auth_with_sms', $mobile, $ttl);
    }

    function getCodeByToken($token)
    {
        $code = cache()->pull($token . 'auth_with_sms');

        return $code;
    }
}
