<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\GroupTask;
use PHPUnit\TextUI\XmlConfiguration\Group;
use App\Repositories\GroupTaskRepository;

class GroupTaskController extends Controller
{

    public function __construct(GroupTaskRepository $groupTaskRepository)
    {
        $this->groupTaskRepository = $groupTaskRepository;
    }

    public function getAll(){
        return GroupTask::all();
    }

    public function getById($id){
        return GroupTask::with(['pending_tasks'])
                    ->where('id', $id)
                    ->first();
    }

    public function create(Request $request){
        return $this->groupTaskRepository->create($request);
    }

    public function update(Request $request, $id){
        return $this->groupTaskRepository->update($request, $id);
    }

    public function delete($id){
        GroupTask::where('id', $id)
            ->delete();

        return [ 'message' => 'Group task deleted' ];
    }

    public function approvedGroupTaskToAvailable(Request $request){
        return $this->groupTaskRepository->approvedGroupTaskToAvailable($request);
    }

    public function declineGroupTask(Request $request){
        return $this->groupTaskRepository->declineGroupTask($request);
    }

}
