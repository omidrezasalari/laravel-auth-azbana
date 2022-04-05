<?php

namespace Authenticate\Providers;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    use Configuration;

    public function register(): void
    {
        $this->config();
        $this->bindings();
    }

    public function boot(): void
    {
        if (!$this->app->routesAreCached()) {
            $this->defineRoutes();
        }

        $this->loadings();
    }


}

