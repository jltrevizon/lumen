<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\VehiclePicture;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Repositories\VehiclePictureRepository;
use Symfony\Component\HttpFoundation\Response as HttpFoundationResponse;

class VehiclePictureController extends Controller
{

    public function __construct(VehiclePictureRepository $vehiclePictureRepository)
    {
        $this->vehiclePictureRepository = $vehiclePictureRepository;
    }

    public function create(Request $request){

        $this->validate($request, [
            'vehicle_id' => 'required|integer',
            'url' => 'required|string',
            'latitude' => 'required|string',
            'longitude' => 'required|string'
        ]);

        return $this->getDataResponse($this->vehiclePictureRepository->create($request), HttpFoundationResponse::HTTP_OK);
    }

    public function delete($id){
        return $this->deleteDataResponse($this->vehiclePictureRepository->delete($id), HttpFoundationResponse::HTTP_OK);
    }

    public function deletePictureByPlace($request){
        return $this->deleteDataResponse($this->vehiclePictureRepository->deletePictureByPlace($request), HttpFoundationResponse::HTTP_OK);
    }

    public function getPicturesByVehicle(Request $request){

        $this->validate($request, [
            'vehicle_id' => 'required|integer'
        ]);

        return $this->getDataResponse($this->vehiclePictureRepository->getPicturesByVehicle($request), HttpFoundationResponse::HTTP_OK);
    }
}
