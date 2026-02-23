<?php

namespace App\Console\Commands;

use App\Models\Register;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class SendDailyEmail extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:send-daily-email';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Envía un correo electrónico diario a las 12:00 PM';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $html = "";

        $servicios = Register::select('name', 'date_expiration', 'status')
                            ->whereRaw('DATE_SUB(date_expiration, INTERVAL 5 DAY) = CURDATE()')
                            ->where('status','=','Pendiente')
                            ->get();

        foreach ($servicios as $servicio) {
            $html .= "- Servicio: {$servicio->name}, Fecha de vencimiento: {$servicio->date_expiration}, Estado: {$servicio->status} \n";
        }

        // Dirección de correo del destinatario
        // $toEmail = 'bjayo027@gmail.com';
        $toEmail = [
            'bjayo027@gmail.com',
            'delia1612@hotmail.com'
        ];

        if (!empty($html)) {
            // Envía el correo usando Mailable
            Mail::raw("Este es un correo electrónico de las servicios pendientes: \n" . $html, function ($message) use ($toEmail) {
                $message->to($toEmail)
                        ->subject('Correo diario desde el administrador de cuentas.');
            });

            $this->info('Correo electrónico enviado correctamente.');
        }
    }
}
