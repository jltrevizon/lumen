<?php

namespace App\Http\Controllers;

use App\Console\Commands\DeliveryVehicles;
use App\Exports\DeliveryVehiclesExport;
use App\Exports\VehiclesExport;
use App\Models\DeliveryNote;
use App\Models\Vehicle;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade as PDF;
use Maatwebsite\Excel\Facades\Excel;

class DownloadController extends Controller
{
    /**
    * @OA\Get(
    *     path="/api/delivery-note-ald",
    *     tags={"downloads"},
    *     summary="get delivery note ald",
    *     @OA\Parameter(
    *       name="customer",
    *       in="query",
    *       description="String",
    *       required=true,
    *       @OA\Schema(
    *           type="string",
    *       )
    *     ),
    *     @OA\Parameter(
    *       name="check",
    *       in="query",
    *       description="Boolean",
    *       required=true,
    *       @OA\Schema(
    *           type="boolean",
    *       )
    *     ),
    *     @OA\Parameter(
    *       name="delivery_no",
    *       in="query",
    *       description="delivery no alb-",
    *       required=true,
    *       @OA\Schema(
    *           type="string",
    *       )
    *     ),
    *     @OA\Parameter(
    *       name="company",
    *       in="query",
    *       description="String",
    *       required=true,
    *       @OA\Schema(
    *           type="string",
    *       )
    *     ),
    *     @OA\Parameter(
    *       name="date_exit",
    *       in="query",
    *       description="date-time",
    *       required=true,
    *       @OA\Schema(
    *           type="string",
    *       )
    *     ),
    *     @OA\Parameter(
    *       name="created",
    *       in="query",
    *       description="date-time",
    *       required=true,
    *       @OA\Schema(
    *           type="string",
    *       )
    *     ),
    *     @OA\Parameter(
    *       name="address",
    *       in="query",
    *       description="string",
    *       required=true,
    *       @OA\Schema(
    *           type="string",
    *       )
    *     ),
    *     @OA\Parameter(
    *       name="reference",
    *       in="query",
    *       description="string",
    *       required=true,
    *       @OA\Schema(
    *           type="string",
    *       )
    *     ),
    *     @OA\Parameter(
    *       name="truck",
    *       in="query",
    *       description="string",
    *       required=true,
    *       @OA\Schema(
    *           type="string",
    *       )
    *     ),
    *     @OA\Parameter(
    *       name="trailer",
    *       in="query",
    *       description="string",
    *       required=true,
    *       @OA\Schema(
    *           type="string",
    *       )
    *     ),
    *     @OA\Parameter(
    *       name="driver",
    *       in="query",
    *       description="string",
    *       required=true,
    *       @OA\Schema(
    *           type="string",
    *       )
    *     ),
    *     @OA\Parameter(
    *       name="dni",
    *       in="query",
    *       description="string",
    *       required=true,
    *       @OA\Schema(
    *           type="string",
    *       )
    *     ),
    *     @OA\Parameter(
    *       name="vehicles",
    *       in="query",
    *       description="string",
    *       example="1,2,3",
    *       required=true,
    *       @OA\Schema(
    *           type="string",
    *       )
    *     ),
    *     @OA\Parameter(
    *       name="total",
    *       in="query",
    *       description="integer",
    *       required=true,
    *       @OA\Schema(
    *           type="integer",
    *       )
    *     ),
    *     @OA\Response(
    *         response=200,
    *         description="Successful operation",
    *          @OA\MediaType(
    *             mediaType="application/pdf",
    *         ),
    *     ),
    * )
    */

    public function deliveryNoteAld(Request $request){
        return Excel::download(new VehiclesExport(1), 'vehicles-' . date('Y-m-d') . '.xlsx');
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
