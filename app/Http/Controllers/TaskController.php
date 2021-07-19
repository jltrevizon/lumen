<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;
use App\Repositories\TaskRepository;

class TaskController extends Controller
{

    public function __construct(TaskRepository $taskRepository)
    {
        $this->taskRepository = $taskRepository;
    }

    public function getAll(){
        return Task::with(['sub_state.state','type_task'])
                    ->get();
    }

    public function getById($id){
        return $this->taskRepository->getById($id);
    }

    public function create(Request $request){

        $this->validate($request, [
            'sub_state_id' => 'required|integer',
            'type_task_id' => 'required|integer',
            'name' => 'required|string',
            'duration' => 'required|integer',
        ]);

        return $this->taskRepository->create($request);
    }

    public function update(Request $request, $id){
        return $this->taskRepository->update($request, $id);
    }

    public function delete($id){
        return $this->taskRepository->delete($id);
    }

}
