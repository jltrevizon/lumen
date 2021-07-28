<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;
use App\Repositories\TaskRepository;
use Symfony\Component\HttpFoundation\Response as HttpFoundationResponse;

class TaskController extends Controller
{

    public function __construct(TaskRepository $taskRepository)
    {
        $this->taskRepository = $taskRepository;
    }

    public function getAll(Request $request){
        return $this->getDataResponse($this->taskRepository->getAll($request), HttpFoundationResponse::HTTP_OK);
    }

    public function getById(Request $request, $id){
        return $this->getDataResponse($this->taskRepository->getById($request, $id), HttpFoundationResponse::HTTP_OK);
    }

    public function create(Request $request){

        $this->validate($request, [
            'sub_state_id' => 'required|integer',
            'type_task_id' => 'required|integer',
            'name' => 'required|string',
            'duration' => 'required|integer',
        ]);

        return $this->createDataResponse($this->taskRepository->create($request), HttpFoundationResponse::HTTP_OK);
    }

    public function update(Request $request, $id){
        return $this->updateDataResponse($this->taskRepository->update($request, $id), HttpFoundationResponse::HTTP_OK);
    }

    public function delete($id){
        return $this->deleteDataResponse($this->taskRepository->delete($id), HttpFoundationResponse::HTTP_OK);
    }

}
