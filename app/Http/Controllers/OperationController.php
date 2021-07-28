<?php

namespace App\Http\Controllers;

use App\Repositories\OperationRepository;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response as HttpFoundationResponse;

class OperationController extends Controller
{
    public function __construct(OperationRepository $operationRepository)
    {
        $this->operationRepository = $operationRepository;
    }

    public function getAll(Request $request){
        return $this->getDataResponse($this->operationRepository->getAll($request), HttpFoundationResponse::HTTP_OK);
    }

    public function getById(Request $request, $id){
        return $this->getDataResponse($this->operationRepository->getById($request, $id), HttpFoundationResponse::HTTP_OK);
    }

    public function create(Request $request){
        $this->validate($request, [
            'vehicle_id' => 'required|integer',
            'pending_task_id' => 'required|integer',
            'operation_type_id' => 'required|integer',
            'description' => 'required|string',
        ]);
        return $this->createDataResponse($this->operationRepository->create($request), HttpFoundationResponse::HTTP_CREATED);
    }

    public function update(Request $request, $id){
        return $this->updateDataResponse($this->operationRepository->update($request, $id), HttpFoundationResponse::HTTP_OK);
    }
}
