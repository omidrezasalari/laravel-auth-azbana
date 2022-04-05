<?php

namespace Authenticate\Providers;

use Authenticate\Facades\AuthFacade;
use Authenticate\Facades\BaseAuth;
use Authenticate\Facades\TokenStore;
use Authenticate\Facades\UserProviderFacade;
use Authenticate\Facades\Eloquent;
use Authenticate\Facades\ResponderFacade;
use Authenticate\Facades\TokenGenerator;
use Authenticate\Facades\TokenGeneratorFacade;
use Authenticate\Facades\TokenStoreFacade;
use Authenticate\Facades\TokenSender;
use Authenticate\Facades\TokenSenderFacade;
use Authenticate\Facades\VueResponder;
use Authenticate\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Schema;

trait Configuration
{
    private $namespace = "Authenticate\\Controllers";

    /**
     * Register service routes.
     *
     * @return void
     */
    private function defineRoutes(): void
    {
        Route::prefix('api')
            ->middleware('api')
            ->namespace($this->namespace)
            ->group(__DIR__ . './../routes/routes.php');
    }

    private function bindings(): void
    {
        UserProviderFacade::shouldProxyTo(Eloquent::class);
        ResponderFacade::shouldProxyTo(VueResponder::class);
        TokenGeneratorFacade::shouldProxyTo(TokenGenerator::class);
        TokenSenderFacade::shouldProxyTo(TokenSender::class);
        TokenStoreFacade::shouldProxyTo(TokenStore::class);
        AuthFacade::shouldProxyTo(BaseAuth::class);
    }

    /**
     * Specify service config.
     *
     * @return void
     */
    private function config(): void
    {
        $this->mergeConfigFrom(
            __DIR__ . '/../config/authenticate_config.php',
            'authenticate_config'
        );

        config()->set('auth.providers.users.model', User::class);
    }

    /**
     * Publish service config files in that path.
     *
     * @return void
     */
    private function publish(): void
    {
        $this->publishes([
            __DIR__ . '/../config/authenticate_config.php' => config_path('authenticate.php')
        ], 'authenticate_config');

        $this->publishes([
            __DIR__ . '/../resources/lang' => resource_path('lang'),
        ], "auth-service");
    }

    /**
     * Specify the path of the files to be read from that path.
     *
     * @return void
     */
    private function loadings(): void
    {
        if (!Schema::hasTable('users')) {
            $this->loadMigrationsFrom(__DIR__ . '/../database/migrations');
        }
        $this->loadTranslationsFrom(__DIR__ . '/../resources/lang', 'authService');
    }
}
