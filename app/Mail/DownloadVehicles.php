<?php

namespace App\Mail;

use App\Exports\VehiclesExport;
use App\Models\PendingDownload;
use App\Models\RequestDownload;
use App\Models\User;
use Faker\Provider\File;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;
use stdClass;

class DownloadVehicles extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct()
    {
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function sendFileVehicles($requestDownload)
    {
        if($requestDownload['user']['company_id'] == null) return false;
        $vehicles = new VehiclesExport($requestDownload['user']['company_id']);

        $user = $requestDownload['user'];
        $data = [
            'message' => 'Adjunto se encuentra el documento con el listado de vehículos.'
        ];
        $file = Excel::download($vehicles, 'vehicles.xlsx')->getFile();
        Mail::send('download-vehicles', $data, function($message) use($user, $vehicles, $file){
            $message->to($user->email, $user->name)->subject('Documento listo!');
            $message->from('no-reply.focus@grupomobius.com','Focus');
            $message->attach($file, ['as' => 'vehicles.xlsx']);
        });

        $updateRequestDownload = PendingDownload::findOrFail($requestDownload['id']);
        $updateRequestDownload->sended = true;
        $updateRequestDownload->save();

    }
}
