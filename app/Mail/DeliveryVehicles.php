<?php

namespace App\Mail;

use App\Exports\DeliveryVehiclesExport;
use App\Models\PeopleForReport;
use App\Models\TypeReport;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;
use Maatwebsite\Excel\Facades\Excel;

class DeliveryVehicles extends Mailable
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
                    ->where('type_report_id', TypeReport::EXITS)
                    ->get();
        $data = [
            'title' => 'Salidas de vehículos',
            'sub_title' => 'Adjunto se encuentra un documento con todas las salidas de vehículos de día ' . date('d-m-Y')
        ];
        $deliveries = new DeliveryVehiclesExport();
        $file = Excel::download($deliveries, 'salidas.xlsx')->getFile();
        foreach($peopleForReport as $user) {
            Mail::send('report-generic', $data, function($message) use($user, $file){
                $message->to($user['user']['email'], $user['user']['name']);
                $message->subject('Salidas de vehículos de la campa');
                $message->from('no-reply.focus@grupomobius.com', 'Focus');
                $message->attach($file, ['as => salidas.xlsx']);
            });
        }
        \unlink($file->getRealPath());
    }
}
