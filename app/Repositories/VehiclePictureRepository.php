<?php

namespace App\Repositories;

use App\Models\Vehicle;
use App\Models\VehiclePicture;
use Illuminate\Support\Facades\Auth;

class VehiclePictureRepository extends Repository {

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function create($request){
        $vehicle = Vehicle::with(['lastReception'])
                    ->findOrFail($request->input('vehicle_id'));
        $vehicle_picture = new VehiclePicture();
        $vehicle_picture->reception_id = $vehicle['lastReception']['id'];
        $vehicle_picture->vehicle_id = $request->input('vehicle_id');
        $vehicle_picture->user_id = Auth::id();
        $vehicle_picture->url = $request->input('url');
        $vehicle_picture->latitude = $request->input('latitude');
        $vehicle_picture->longitude = $request->input('longitude');
        $vehicle_picture->save();
        return VehiclePicture::where('vehicle_id', $request->input('vehicle_id'))
                ->get();
    }

    public function getPicturesByVehicle($request){
        return VehiclePicture::with($this->getWiths($request->with))
                    ->where('vehicle_id', $request->input('vehicle_id'))
                    ->get();
    }

}
