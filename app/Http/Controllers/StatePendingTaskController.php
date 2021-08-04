<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\StatePendingTask;
use App\Repositories\StatePendingTaskRepository;
use Symfony\Component\HttpFoundation\Response as HttpFoundationResponse;

class StatePendingTaskController extends Controller
{

    public function __construct(StatePendingTaskRepository $statePendingTaskRepository)
    {
        $this->statePendingTaskRepository = $statePendingTaskRepository;
    }

    public function getAll(){
        return $this->getDataResponse(StatePendingTask::all(), HttpFoundationResponse::HTTP_OK);
    }

    public function getById($id){
        return $this->getDataResponse($this->statePendingTaskRepository->getById($id), HttpFoundationResponse::HTTP_OK);
    }

    public function create(Request $request){

        $this->validate($request, [
            'name' => 'required|string'
        ]);

        return $this->createDataResponse($this->statePendingTaskRepository->create($request), HttpFoundationResponse::HTTP_CREATED);
    }

    public function update(Request $request, $id){
        return $this->updateDataResponse($this->statePendingTaskRepository->update($request, $id), HttpFoundationResponse::HTTP_OK);
    }

    public function delete($id){
        return $this->deleteDataResponse($this->statePendingTaskRepository->delete($id), HttpFoundationResponse::HTTP_OK);
    }
}
