<?php

namespace App\Mail;

use App\Exports\StockVehiclesExport;
use App\Models\PeopleForReport;
use App\Models\TypeReport;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;
use Maatwebsite\Excel\Facades\Excel;

class StockVehicles extends Mailable
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
        $peopleForReport = PeopleForReport::with(['user'])
                ->where('type_report_id', TypeReport::STOCK)
                ->get();
        $data = [
            'title' => 'Entradas de vehículos',
            'sub_title' => 'Adjunto se encuentra un documento con el listado de todas las entradas de campa del ' . date('d-m-Y')
        ];
        $receptions = new StockVehiclesExport();
        $file = Excel::download($receptions, 'entradas.xlsx')->getFile();
        foreach($peopleForReport as $user){
            Mail::send('report-generic', $data, function($message) use($user, $file){
                $message->to($user['user']['email'], $user['user']['name']);
                $message->subject('Entradas de vehículos a campa');
                $message->from('inout@mkdautomotive.com', 'Focus');
                $message->attach($file, ['as => entradas.xlsx']);
            });
        }
        \unlink($file->getRealPath());
    }
}
