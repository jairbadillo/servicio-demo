<?php

namespace Database\Seeders;

use App\Models\Register;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

/**
 * JB - Seeder de registros default para la demo.
 *
 * Se usa en DOS situaciones:
 *   1. Al setup inicial: php artisan db:seed --class=RegisterSeeder
 *   2. Al hacer logout: AuthenticatedSessionController llama a resetDemoData()
 *      que borra la tabla y llama a este seeder automáticamente.
 *
 * De esta forma la BD siempre vuelve a estos 15 registros después de cada sesión.
 */
class RegisterSeeder extends Seeder
{
    public function run(): void
    {
        DB::statement('ALTER TABLE registers AUTO_INCREMENT = 16');
        $mes = now()->format('Y-m');

        // Borra todos los registros actuales antes de insertar los default.
        // truncate() es más rápido que delete() y resetea el auto_increment.
        Register::truncate();

        $registros = [
            ['name' => 'Netflix',              'date_expiration' => $mes.'-02', 'balance' => 2499.00,  'status' => 'pa'],
            ['name' => 'Spotify',              'date_expiration' => $mes.'-04', 'balance' => 799.00,   'status' => 'pa'],
            ['name' => 'Amazon Prime',         'date_expiration' => $mes.'-05', 'balance' => 1500.00,  'status' => 'pe'],
            ['name' => 'Disney+',              'date_expiration' => $mes.'-07', 'balance' => 1200.50,  'status' => 're'],
            ['name' => 'HBO Max',              'date_expiration' => $mes.'-08', 'balance' => 1899.00,  'status' => 'pe'],
            ['name' => 'YouTube Premium',      'date_expiration' => $mes.'-10', 'balance' => 999.00,   'status' => 'pa'],
            ['name' => 'iCloud Storage 2TB',   'date_expiration' => $mes.'-12', 'balance' => 499.99,   'status' => 'pe'],
            ['name' => 'Adobe Creative Cloud', 'date_expiration' => $mes.'-14', 'balance' => 12000.00, 'status' => 're'],
            ['name' => 'Microsoft 365',        'date_expiration' => $mes.'-16', 'balance' => 3200.00,  'status' => 'pa'],
            ['name' => 'NordVPN',              'date_expiration' => $mes.'-18', 'balance' => 8500.00,  'status' => 'pe'],
            ['name' => 'Google One 2TB',       'date_expiration' => $mes.'-19', 'balance' => 650.00,   'status' => 'pa'],
            ['name' => 'Dropbox Plus',         'date_expiration' => $mes.'-21', 'balance' => 4800.00,  'status' => 'pe'],
            ['name' => 'Canva Pro',            'date_expiration' => $mes.'-23', 'balance' => 1100.00,  'status' => 're'],
            ['name' => 'ChatGPT Plus',         'date_expiration' => $mes.'-25', 'balance' => 2000.00,  'status' => 'pe'],
            ['name' => 'GitHub Copilot',       'date_expiration' => $mes.'-28', 'balance' => 1300.00,  'status' => 'pa'],
        ];

        // Insert masivo: más eficiente que un loop con create()
        Register::insert($registros);
    }

    /**
     * JB - Método estático para llamar desde el logout sin instanciar el Seeder.
     *
     * AuthenticatedSessionController::destroy() llama a este método
     * para resetear la BD al hacer logout.
     *
     * Puede llamarse así desde cualquier parte del código:
     *   RegisterSeeder::resetDemoData();
     */
    public static function resetDemoData(): void
    {
        DB::statement('ALTER TABLE registers AUTO_INCREMENT = 16');
        
        $mes = now()->format('Y-m');

        Register::truncate();

        Register::insert([
            ['name' => 'Netflix',              'date_expiration' => $mes.'-02', 'balance' => 2499.00,  'status' => 'pa', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Spotify',              'date_expiration' => $mes.'-04', 'balance' => 799.00,   'status' => 'pa', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Amazon Prime',         'date_expiration' => $mes.'-05', 'balance' => 1500.00,  'status' => 'pe', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Disney+',              'date_expiration' => $mes.'-07', 'balance' => 1200.50,  'status' => 're', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'HBO Max',              'date_expiration' => $mes.'-08', 'balance' => 1899.00,  'status' => 'pe', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'YouTube Premium',      'date_expiration' => $mes.'-10', 'balance' => 999.00,   'status' => 'pa', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'iCloud Storage 2TB',   'date_expiration' => $mes.'-12', 'balance' => 499.99,   'status' => 'pe', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Adobe Creative Cloud', 'date_expiration' => $mes.'-14', 'balance' => 12000.00, 'status' => 're', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Microsoft 365',        'date_expiration' => $mes.'-16', 'balance' => 3200.00,  'status' => 'pa', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'NordVPN',              'date_expiration' => $mes.'-18', 'balance' => 8500.00,  'status' => 'pe', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Google One 2TB',       'date_expiration' => $mes.'-19', 'balance' => 650.00,   'status' => 'pa', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Dropbox Plus',         'date_expiration' => $mes.'-21', 'balance' => 4800.00,  'status' => 'pe', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Canva Pro',            'date_expiration' => $mes.'-23', 'balance' => 1100.00,  'status' => 're', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'ChatGPT Plus',         'date_expiration' => $mes.'-25', 'balance' => 2000.00,  'status' => 'pe', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'GitHub Copilot',       'date_expiration' => $mes.'-28', 'balance' => 1300.00,  'status' => 'pa', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}
