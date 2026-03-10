<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        if (app()->environment(['local', 'demo'])) {
            view()->share([
                'imgFondo' => asset('images/fondo-login-demo.png'),
                'imgLogo'  => asset('images/logo-demo.png'),
            ]);

        } else {
            view()->share([
                'imgFondo' => asset('images/fondo-login-prod.png'),
                'imgLogo'  => asset('images/logo-prod.png'),
            ]);
        }
    }
}
