<?php

namespace App\Http\Controllers;

use App\Models\DeliveryNote;
use App\Models\Vehicle;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade as PDF;

class DownloadController extends Controller
{
    public function deliveryNoteAld(Request $request){

        $vehicles = Vehicle::with(['vehicleModel'])
                            ->whereIn('id', explode(',', $request->input('vehicles')))
                            ->get();
        $data = [];
        $deliveryNote = new DeliveryNote();
        $deliveryNote->body = json_encode($data);
        $deliveryNote->save();
        $data = [
            'customer' => $request->input('customer'),
            'check' => $request->input('check'),
            'delivery_no' => 'Alb-' . $deliveryNote->id,
            'company' => $request->input('company'),
            'date_exit' => $request->input('date_exit'),
            'created' => date('Y-m-d'),
            'address' => $request->input('address'),
            'reference' => $request->input('reference'),
            'truck' => $request->input('truck'),
            'trailer' => $request->input('trailer'),
            'driver' => $request->input('driver'),
            'dni' => $request->input('dni'),
            'vehicles' => $vehicles,
            'total' => count($vehicles)
        ];
        $deliveryNote->body = json_encode($data);
        $deliveryNote->save();
        $pdf = PDF::loadView('delivery-note-ald', $data);
        return $pdf->download('alb-' . $deliveryNote->id . '.pdf');
    }
}