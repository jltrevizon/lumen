<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\State;
use App\Repositories\StateRepository;
use Symfony\Component\HttpFoundation\Response as HttpFoundationResponse;

class StateController extends Controller
{

    public function __construct(StateRepository $stateRepository)
    {
        $this->stateRepository = $stateRepository;
    }

    public function getAll(){
        return $this->getDataResponse(State::all(), HttpFoundationResponse::HTTP_OK);
    }

    public function getById($id){
        return $this->getDataResponse($this->stateRepository->getById($id), HttpFoundationResponse::HTTP_OK);
    }

    public function getStatesWithVehicles(Request $request){
        return $this->getDataResponse($this->stateRepository->getStatesWithVehicles($request), HttpFoundationResponse::HTTP_OK);
    }

    public function getStatesWithVehiclesCampa(Request $request){
        return $this->getDataResponse($this->stateRepository->getStatesWithVehiclesCampa($request), HttpFoundationResponse::HTTP_OK);
    }

    public function create(Request $request){

        $this->validate($request, [
            'name' => 'required|string'
        ]);

        return $this->createDataResponse($this->stateRepository->create($request), HttpFoundationResponse::HTTP_CREATED);
    }

    public function update(Request $request, $id){
        return $this->updateDataResponse($this->stateRepository->update($request, $id), HttpFoundationResponse::HTTP_OK);
    }

    public function delete($id){
        return $this->deleteDataResponse($this->stateRepository->delete($id), HttpFoundationResponse::HTTP_OK);
    }
}
