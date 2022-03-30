<?php

namespace App\Mail;

use App\Models\Vehicle;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class NotificationDAMail extends Mailable
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
    public function build($vehicleId)
    {
        $vehicle = Vehicle::with(['vehicleModel.brand'])
            ->findOrFail($vehicleId);
            $data = [
                'vehicle' => $vehicle
            ];
        if(env('APP_ENV') == 'production'){
            Mail::send('notificationDA', $data, function ($message) {
                $message->to(env('EMAIL_FLOTA'), env('NAME_FLOTA'));
                $message->subject('Incidencia Distintivo Ambiental');
                $message->from(env('MAIL_FROM_NAME'));
            });
        }
    }
}
