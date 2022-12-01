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

    public function getAll(Request $request){
        return $this->getDataResponse($this->vehicleModelRepository->getAll($request), HttpFoundationResponse::HTTP_OK);
    }

    public function store(Request $request){
        return $this->createDataResponse($this->vehicleModelRepository->store($request), HttpFoundationResponse::HTTP_OK);
    }

    public function update(Request $request, $id){
        return $this->updateDataResponse($this->vehicleModelRepository->update($request, $id), HttpFoundationResponse::HTTP_OK);
    }
}
