<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Database\Seeders\RegisterSeeder;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Muestra el formulario de login.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Procesa el login — sin cambios respecto al original.
     * El login funciona exactamente igual con Eloquent y la BD de usuarios.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        $request->session()->regenerate();

        // JB - Reset de la BD al hacer login Y al hacer logout.
        // Cubre el caso donde el usuario cierra la web sin hacer logout.
        // Así el próximo usuario siempre entra con los 15 registros default.

        if (app()->environment(['local', 'demo'])) {
            RegisterSeeder::resetDemoData();
        }
        
        return redirect()->intended(route('dashboard', absolute: false));
    }

    /**
     * JB - Procesa el logout y resetea la BD a los datos default.
     *
     * Al hacer logout:
     *   1. Se cierra la sesión del usuario (comportamiento original)
     *   2. Se llama a RegisterSeeder::resetDemoData() que:
     *      - Borra TODOS los registros de la tabla con truncate()
     *      - Inserta los 15 registros default del mes actual
     *   3. El próximo usuario que entre verá la BD como al principio
     *
     * PRODUCCIÓN REAL (si algún día dejás de ser demo):
     *   Comentar la línea RegisterSeeder::resetDemoData()
     *   y el use Database\Seeders\RegisterSeeder de arriba.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        // Reset de la BD al hacer logout
        // Borra todo y vuelve a cargar los 15 registros default
        if (app()->environment(['local', 'demo'])) {
            RegisterSeeder::resetDemoData();
        }

        return redirect('/');
    }
}
