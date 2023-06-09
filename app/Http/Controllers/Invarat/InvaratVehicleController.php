<?php

namespace App\Http\Controllers\Invarat;

use App\Http\Controllers\Controller;
use App\Repositories\Invarat\InvaratVehicleRepository;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response as HttpFoundationResponse;

class InvaratVehicleController extends Controller
{
    public function __construct(InvaratVehicleRepository $invaratVehicleRepository)
    {
        $this->invaratVehicleRepository = $invaratVehicleRepository;
    }

    public function createVehicle(Request $request){
        return $this->createDataResponse($this->invaratVehicleRepository->createVehicle($request), HttpFoundationResponse::HTTP_CREATED);
    }

    public function vehiclesByChannel(Request $request){
        return $this->getDataResponse($this->invaratVehicleRepository->vehiclesByChannel($request), HttpFoundationResponse::HTTP_OK);
    }

    public function createChecklistEmpty(Request $request){
        return $this->getDataResponse($this->invaratVehicleRepository->createChecklistEmpty($request), HttpFoundationResponse::HTTP_OK);
    }

    public function getVehicleResults(Request $request){
        return $this->getDataResponse($this->invaratVehicleRepository->getVehicleResults($request), HttpFoundationResponse::HTTP_OK);
    }

    public function getVehicleDetails(Request $request){
        return $this->getDataResponse($this->invaratVehicleRepository->getVehicleDetails($request), HttpFoundationResponse::HTTP_OK);
    }

    public function update(Request $request, $id)
    {
        return $this->updateDataResponse(['vehicle' => $this->invaratVehicleRepository->update($request, $id)], HttpFoundationResponse::HTTP_OK);
    }
}
