<?php

namespace Authenticate\Facades;

class TokenGenerator
{

    public function generateToken()
    {
        return random_int(10000, 99999);
    }
}
