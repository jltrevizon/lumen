<?php

namespace App\Repositories;

use App\Models\VehiclePicture;
use Illuminate\Support\Facades\Auth;

class VehiclePictureRepository {

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function create($request){
        $vehicle_picture = new VehiclePicture();
        $user = $this->userRepository->getById(Auth::id());
        $vehicle_picture->vehicle_id = $request->json()->get('vehicle_id');
        $vehicle_picture->user_id = Auth::id();
        $vehicle_picture->campa_id = $user->campa_id;
        $vehicle_picture->url = $request->json()->get('url');
        $vehicle_picture->latitude = $request->json()->get('latitude');
        $vehicle_picture->longitude = $request->json()->get('longitude');
        $vehicle_picture->save();
        return VehiclePicture::where('vehicle_id', $request->json()->get('vehicle_id'))
                            ->get();
    }

    public function getPicturesByVehicle($request){
        return VehiclePicture::with(['vehicle'])
                            ->where('vehicle_id', $request->json()->get('vehicle_id'))
                            ->get();
    }

}
