<?php

namespace App\Providers;

use App\Http\Controllers\ProcessosController;
use Illuminate\Support\ServiceProvider;

class ProcessosServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('ProcessosService',function ($app) {
            return new ProcessosController();
        });
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
