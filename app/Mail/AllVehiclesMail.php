<?php

namespace App\Mail;

use App\Console\Commands\AllVehicles;
use App\Exports\AllVehiclesExport;
use App\Models\PeopleForReport;
use App\Models\TypeReport;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;
use Maatwebsite\Excel\Facades\Excel;

class AllVehiclesMail extends Mailable
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
            'title' => 'Stock de todos los vehículos',
            'sub_title' => 'Adjunto se encuentra un documento con el stock de los vehículos al día ' . date('d-m-Y H:i:s') . '. Este documento contiene todos los vehículos sin importar el estado en que se encuentren.'
        ];
        $file = Excel::download(new AllVehiclesExport, 'entradas.xlsx')->getFile();
        rename($file->getRealPath(), $file->getPath() . '/' . 'vehículos.xlsx');
        $fileRename = $file->getPath() . '/vehículos.xlsx';
        foreach($peopleForReport as $user){
            Mail::send('report-generic', $data, function($message) use($user, $fileRename){
                $message->to($user['user']['email'], $user['user']['name']);
            $message->subject('Stock de vehículos');
            $message->from('no-reply.focus@grupomobius.com', 'Focus');
            $message->attach($fileRename, ['as => vehiculos.xlsx']);
            });
        }
        \unlink($file->getPath() . '/vehículos.xlsx');
    }
}
