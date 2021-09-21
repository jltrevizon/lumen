<?php

namespace App\Mail;

use App\Exports\EntriesVehiclesExport;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;
use Maatwebsite\Excel\Facades\Excel;

class EntriesVehicles extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $receptions = new EntriesVehiclesExport();
        $data = [
            'title' => 'Entradas de vehículos',
            'sub_title' => 'Adjunto se encuentra un documento con el listado de todas las entradas de campa del ' . date('d-m-Y')
        ];
        $user = [
            'email' => 'anelvin.mejia@grupomobius.com',
            'name' => 'Anelvin Mejía',
        ];
        $file = Excel::download($receptions, 'entradas.xlsx')->getFile();
          Mail::send('report-generic', $data, function($message) use($user, $file){
            $message->to($user['email'], $user['name']);
            $message->subject('Entradas de vehículos a campa');
            $message->from('inout@mkdautomotive.com', 'Focus');
            $message->attach($file, ['as => entradas.xlsx']);
        });
        \unlink($file->getRealPath());
    }
}
