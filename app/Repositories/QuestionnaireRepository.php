<?php

namespace App\Repositories;

use Exception;
use App\Models\Vehicle;
use App\Models\GroupTask;
use App\Models\Reception;
use App\Models\PendingTask;
use App\Models\Questionnaire;
use App\Models\StatePendingTask;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class QuestionnaireRepository extends Repository {

    public function __construct()
    {

    }

    public function index($request){
            if(!is_null($request->vehiclePlate)){
                $vehicle = Vehicle::where('plate', $request->vehiclePlate)->first();
                if($vehicle){
                    $this->deleteDuplicate($vehicle);
                }
                
            }
            return Questionnaire::with($this->getWiths($request->with))
            ->whereRaw('vehicle_id NOT IN(SELECT id FROM vehicles WHERE deleted_at is not null)')
            ->filter($request->all())
            ->paginate($request->input('per_page'));
        
    }

    public function create($vehicleId){
        $vehicle = Vehicle::findOrFail($vehicleId);
        return  Questionnaire::create([
            'user_id' => Auth::id(),
            'vehicle_id' => $vehicle->id,
            'reception_id' =>  $vehicle->lastReception->id
        ]);
    }

    public function getById($request, $id){
        return Questionnaire::with($this->getWiths($request->with))
                    ->findOrFail($id);
    }

    public function deleteDuplicate($vehicle){
        $last_reception = Reception::where('vehicle_id', $vehicle->id)->orderBy('id', 'DESC')
                            ->first();
        
        $group_task = GroupTask::where('vehicle_id', $vehicle->id)
                        ->where('approved', 0)
                        //->orderBy('id', 'desc')
                        ->get();
        $group_task->pop();
        foreach ($group_task as $gr_task) {
            if(!is_null($gr_task->questionnaire_id)){
                Questionnaire::where('id', $gr_task->questionnaire_id)->delete();
                //$gr_task->questionnaire_id = null;
                //$gr_task->save();
            }
            $this->cancelAllPendingTask($gr_task->id);
            $gr_task->delete();
        }
        
        return;

    }

    public function cancelAllPendingTask($group_task_id){
        $pendingTask = PendingTask::where('group_task_id', $group_task_id)->get();
        foreach($pendingTask as $pending){
            if($pending->state_pending_task_id !== StatePendingTask::FINISHED){
                $pending->state_pending_task_id = StatePendingTask::CANCELED;
                $pending->save();
            }
        }
        
        return;
    }

}
