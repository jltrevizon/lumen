<?php

namespace App\Mail;

use App\Models\Vehicle;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class NotificationItvMail extends Mailable
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
            Mail::send('notificationITV', $data, function ($message) {
                $message->to(env('EMAIL_ITV', env('NAME_ITV')));
                $message->subject('Incidencia ITV');
                $message->from(env('MAIL_FROM_NAME'));
            });
        }
    }
}
