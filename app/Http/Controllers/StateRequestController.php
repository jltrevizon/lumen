<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\StateRequest;
use App\Repositories\StateRequestRepository;
use Symfony\Component\HttpFoundation\Response as HttpFoundationResponse;

class StateRequestController extends Controller
{

    public function __construct(StateRequestRepository $stateRequestRepository)
    {
        $this->stateRequestRepository = $stateRequestRepository;
    }

    public function getAll(){
        return $this->getDataResponse(StateRequest::all(), HttpFoundationResponse::HTTP_OK);
    }

    public function getById($id){
        return $this->getDataResponse($this->stateRequestRepository->getById($id), HttpFoundationResponse::HTTP_OK);
    }

    public function create(Request $request){

        $this->validate($request, [
            'name' => 'required|string'
        ]);

        return $this->createDataResponse($this->stateRequestRepository->create($request), HttpFoundationResponse::HTTP_CREATED);
    }

    public function update(Request $request, $id){
        return $this->updateDataResponse($this->stateRequestRepository->update($request, $id), HttpFoundationResponse::HTTP_OK);
    }

    public function delete($id){
        return $this->deleteDataResponse($this->stateRequestRepository->delete($id), HttpFoundationResponse::HTTP_OK);
    }
}
