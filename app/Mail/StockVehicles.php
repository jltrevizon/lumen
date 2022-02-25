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
            'title' => 'Stock de vehículos',
            'sub_title' => 'Adjunto se encuentra un documento con el stock de los vehículos al día ' . date('d-m-Y H:i:s')
        ];
        $file = Excel::download(new StockVehiclesExport, 'entradas.xlsx')->getFile();
        rename($file->getRealPath(), $file->getPath() . '/' . 'stock-vehículos.xlsx');
        $fileRename = $file->getPath() . '/stock-vehículos.xlsx';
        foreach($peopleForReport as $user){
            Mail::send('report-generic', $data, function($message) use($user, $fileRename){
                $message->to($user['user']['email'], $user['user']['name']);
               $message->subject('Stock de vehículos');
               $message->from('inout@mkdautomotive.com', 'Focus');
               $message->attach($fileRename, ['as => entradas.xlsx']);
            });
        }
        \unlink($file->getPath() . '/stock-vehículos.xlsx');
    }
}
