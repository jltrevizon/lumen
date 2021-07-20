<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\State;
use App\Repositories\StateRepository;

class StateController extends Controller
{

    public function __construct(StateRepository $stateRepository)
    {
        $this->stateRepository = $stateRepository;
    }

    public function getAll(){
        return State::all();
    }

    public function getById($id){
        return $this->stateRepository->getById($id);
    }

    public function getStatesWithVehicles(Request $request){
        return $this->stateRepository->getStatesWithVehicles($request);
    }

    public function getStatesWithVehiclesCampa(Request $request){
        return $this->stateRepository->getStatesWithVehiclesCampa($request);
    }

    public function create(Request $request){

        $this->validate($request, [
            'name' => 'required|string'
        ]);

        return $this->stateRepository->create($request);
    }

    public function update(Request $request, $id){
        return $this->stateRepository->update($request, $id);
    }

    public function delete($id){
        return $this->stateRepository->delete($id);
    }
}
