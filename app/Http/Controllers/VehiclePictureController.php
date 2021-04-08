<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\VehiclePicture;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class VehiclePictureController extends Controller
{
    public function create(Request $request){
        $vehicle_picture = new VehiclePicture();
        $user = User::where('id', Auth::id())
                    ->first();
        $vehicle_picture->vehicle_id = $request->json()->get('vehicle_id');
        $vehicle_picture->user_id = Auth::id();
        $vehicle_picture->campa_id = $user->campa_id;
        $vehicle_picture->url = $request->json()->get('url');
        $vehicle_picture->latitude = $request->json()->get('latitude');
        $vehicle_picture->longitude = $request->json()->get('longitude');
        $vehicle_picture->save();
        return $vehicle_picture;
    }

    public function getPicturesByVehicle(Request $request){
        return VehiclePicture::with(['vehicle'])
                            ->where('vehicle_id', $request->json()->get('vehicle_id'))
                            ->get();
    }
}
