<?php

namespace Authenticate\Facades;

use Trez\RayganSms\Facades\RayganSms;

class TokenSender
{

    public function send($mobile, $token)
    {
        RayganSms::sendAuthCode(
            str_replace("+98", "0", $mobile),
            __('authService::message.token', ['token' => $token]),
            false
        );
    }
}
