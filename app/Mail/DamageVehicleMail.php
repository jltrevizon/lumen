<?php

namespace App\Mail;

use App\Models\NotifyDamage;
use App\Models\SeverityDamage;
use App\Models\Vehicle;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class DamageVehicleMail extends Mailable
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
        //
    }

    /**
     * Build the message.
     *
     * @return void
     */
    public function SendDamage($request)
    {
        $emails = [];
        $vehicle = Vehicle::findOrFail($request->input('vehicle_id'));
        $severity = SeverityDamage::findOrFail($request->input('severity_damage_id'));

        if ($request->input('notificable_taller')) {
            $emails = NotifyDamage::where('task_id', $request->input('task_id'))
                ->select('email', 'name')
                ->get()
                ->toArray();
        }

        if ($request->input('notificable_invarat')) {
            array_push($emails, ['email' => 'finalizacionescarflex@invarat.com', 'name' => 'Finalizaciones Carflex']);
        }

        $data = [
            'vehicle' => $vehicle,
            'severity' => $severity,
            'description' => $request->input('description')
        ];

        foreach($emails as $email){
            Mail::send('damage-vehicle', $data, function($message) use ($email, $vehicle){
                $message->to($email['email'], $email['name']);
                $message->subject('Incidencia reportada Focus - ['.$vehicle->plate.']');
                $message->from('inout@mkdautomotive.com', 'Focus');
            });
        }
    }
}
