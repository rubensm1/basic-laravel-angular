<?php

namespace App\Providers;

use App\Http\Controllers\UsuarioController;
use Illuminate\Support\ServiceProvider;

class UsuariosServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('UsuariosService',function ($app) {
            return new UsuarioController();
        });
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        
    }
}
