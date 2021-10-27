<?php

namespace App\Http\Controllers;

use App\Models\VehicleModel;
use App\Repositories\VehicleModelRepository;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response as HttpFoundationResponse;

class VehicleModelController extends Controller
{
    public function __construct(VehicleModelRepository $vehicleModelRepository)
    {
        $this->vehicleModelRepository = $vehicleModelRepository;
    }

    public function getAll(){
        return $this->getDataResponse($this->vehicleModelRepository->getAll(), HttpFoundationResponse::HTTP_OK);
    }

    public function store(Request $request){
        return $this->createDataResponse($this->vehicleModelRepository->store($request), HttpFoundationResponse::HTTP_OK);
    }
}
