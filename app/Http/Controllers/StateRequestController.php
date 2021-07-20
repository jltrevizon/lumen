<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\StateRequest;
use App\Repositories\StateRequestRepository;

class StateRequestController extends Controller
{

    public function __construct(StateRequestRepository $stateRequestRepository)
    {
        $this->stateRequestRepository = $stateRequestRepository;
    }

    public function getAll(){
        return StateRequest::all();
    }

    public function getById($id){
        return $this->stateRequestRepository->getById($id);
    }

    public function create(Request $request){

        $this->validate($request, [
            'name' => 'required|string'
        ]);

        return $this->stateRequestRepository->create($request);
    }

    public function update(Request $request, $id){
        return $this->stateRequestRepository->update($request);
    }

    public function delete($id){
        return $this->stateRequestRepository->delete($id);
    }
}
