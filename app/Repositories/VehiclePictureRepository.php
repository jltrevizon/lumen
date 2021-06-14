<?php

namespace App\Repositories;

use App\Models\VehiclePicture;
use Exception;
use Illuminate\Support\Facades\Auth;

class VehiclePictureRepository {

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function create($request){
        try {
            $vehicle_picture = new VehiclePicture();
            $user = $this->userRepository->getById(Auth::id());
            $vehicle_picture->vehicle_id = $request->input('vehicle_id');
            $vehicle_picture->user_id = Auth::id();
            $vehicle_picture->campa_id = $user->campa_id;
            $vehicle_picture->url = $request->input('url');
            $vehicle_picture->latitude = $request->input('latitude');
            $vehicle_picture->longitude = $request->input('longitude');
            $vehicle_picture->save();
            return VehiclePicture::where('vehicle_id', $request->input('vehicle_id'))
                                ->get();
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], 409);
        }
    }

    public function getPicturesByVehicle($request){
        try {
            return VehiclePicture::with(['vehicle'])
                                ->where('vehicle_id', $request->input('vehicle_id'))
                                ->get();
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], 409);
        }
    }

}
