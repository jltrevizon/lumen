<?php

namespace App\Http\Controllers;

use App\Repositories\VehicleExitRepository;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response as HttpFoundationResponse;

class VehicleExitController extends Controller
{
    public function __construct(VehicleExitRepository $vehicleExitRepository)
    {
        $this->vehicleExitRepository = $vehicleExitRepository;
    }

    public function getAll(Request $request){
        return $this->getDataResponse($this->vehicleExitRepository->getAll($request), HttpFoundationResponse::HTTP_OK);
    }

    public function getById(Request $request, $id){
        return $this->getDataResponse($this->vehicleExitRepository->getById($request, $id), HttpFoundationResponse::HTTP_OK);
    }

    public function create(Request $request){
        $this->validate($request, [
            'vehicle_id' => 'required|integer',
            'pending_task_id' => 'required|integer',
            'delivery_by' => 'required|string',
            'delivery_to' => 'required|string',
            'name_place' => 'required|string'
        ]);
        return $this->createDataResponse($this->vehicleExitRepository->create($request), HttpFoundationResponse::HTTP_CREATED);
    }

    public function update(Request $request, $id){
        return $this->updateDataResponse($this->vehicleExitRepository->update($request, $id), HttpFoundationResponse::HTTP_OK);
    }

}
