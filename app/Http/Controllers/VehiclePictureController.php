<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\VehiclePicture;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Repositories\VehiclePictureRepository;

class VehiclePictureController extends Controller
{

    public function __construct(VehiclePictureRepository $vehiclePictureRepository)
    {
        $this->vehiclePictureRepository = $vehiclePictureRepository;
    }

    public function create(Request $request){
        return $this->vehiclePictureRepository->create($request);
    }

    public function getPicturesByVehicle(Request $request){
        return $this->vehiclePictureRepository->getPicturesByVehicle($request);
    }
}
