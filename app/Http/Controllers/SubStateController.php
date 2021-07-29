<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SubState;
use App\Repositories\SubStateRepository;
use Symfony\Component\HttpFoundation\Response as HttpFoundationResponse;

class SubStateController extends Controller
{

    public function __construct(SubStateRepository $subStateRepository)
    {
        $this->subStateRepository = $subStateRepository;
    }

    public function getAll(Request $request){
        return $this->getDataResponse($this->subStateRepository->getAll($request), HttpFoundationResponse::HTTP_OK);
    }

    public function getById($id){
        return $this->getDataResponse($this->subStateRepository->getById($id), HttpFoundationResponse::HTTP_OK);
    }

    public function create(Request $request){

        $this->validate($request, [
            'state_id' => 'required|integer',
            'name' => 'required|string'
        ]);

        return $this->createDataResponse($this->subStateRepository->create($request), HttpFoundationResponse::HTTP_CREATED);
    }

    public function update(Request $request, $id){
        return $this->updateDataResponse($this->subStateRepository->update($request, $id), HttpFoundationResponse::HTTP_OK);
    }

    public function delete($id){
        return $this->deleteDataResponse($this->subStateRepository->update($id), HttpFoundationResponse::HTTP_OK);
    }
}
