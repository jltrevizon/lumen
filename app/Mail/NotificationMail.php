<?php

namespace App\Mail;

use App\Models\Damage;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class NotificationMail extends Mailable
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
    public function build($roleId, $damageId)
    {
        $users = User::where('role_id', $roleId)->get();
        $damage = Damage::with(['vehicle.vehicleModel.brand','damageType','roles','tasks'])
        ->findOrFail($damageId);
        $data = [
            'damage' => $damage,
        ];
        foreach($users as $user){
            Mail::send('incidences', $data, function ($message) use($user){
                $message->to($user['email'], $user['name']);
                $message->subject('Nueva incidencia');
                $message->from('no-reply.focus@grupomobius.com', 'Focus');
            });
        }
    }
}
