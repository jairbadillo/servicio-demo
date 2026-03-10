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
                'imgFondo' => asset('images/Fondo-login-demo.png'),
                'imgLogo'  => asset('images/Logo-demo.png'),
            ]);

        } else {
            view()->share([
                'imgFondo' => asset('images/Fondo-login-prod.png'),
                'imgLogo'  => asset('images/Logo-prod.png'),
            ]);
        }
    }
}
