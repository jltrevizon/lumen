<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Mail;
use Illuminate\Queue\SerializesModels;

class SendCode
{
    //use Queueable, SerializesModels;

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
    public function SendCodePassword($name, $code, $email)
    {
       // return 'Hola';
       $data = ['name' => $name, 'code' => $code];
        Mail::send('mail', $data, function($message) use($email, $name){
            $message->to($email, $name)->subject('Restablecer contraseña!');
            $message->from('no-reply.focus@grupomobius.com','Focus');
        });
    }
}
