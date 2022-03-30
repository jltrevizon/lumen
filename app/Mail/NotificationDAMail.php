<?php

namespace App\Mail;

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
    public function build()
    {
        if(env('APP_ENV') != 'production'){
            Mail::send('notificationDA', [], function ($message) {
                $message->to('anelvin.mejia@grupomobius.com', 'Anelvin');
                $message->subject('Incidencia Distintivo Ambiental');
                $message->from(env('MAIL_FROM_NAME'));
            });
        }
    }
}
