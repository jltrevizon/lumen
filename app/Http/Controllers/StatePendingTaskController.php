<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\StatePendingTask;
use App\Repositories\StatePendingTaskRepository;

class StatePendingTaskController extends Controller
{

    public function __construct(StatePendingTaskRepository $statePendingTaskRepository)
    {
        $this->statePendingTaskRepository = $statePendingTaskRepository;
    }

    public function getAll(){
        return StatePendingTask::all();
    }

    public function getById($id){
        return $this->statePendingTaskRepository->getById($id);
    }

    public function create(Request $request){

        $this->validate($request, [
            'name' => 'required|string'
        ]);

        return $this->statePendingTaskRepository->create($request);
    }

    public function update(Request $request, $id){
        return $this->statePendingTaskRepository->update($request, $id);
    }

    public function delete($id){
        return $this->statePendingTaskRepository->delete($id);
    }
}
