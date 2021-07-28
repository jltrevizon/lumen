<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Vehicle;
use App\Models\Task;
use App\Models\StatePendingTask;
use App\Models\GroupTask;
use App\Models\Incidence;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PendingTask extends Model
{

    use HasFactory;

    protected $fillable = [
        'vehicle_id',
        'task_id',
        'state_pending_task_id',
        'group_task_id',
        'duration',
        'order',
        'approved',
        'code_authorization',
        'status_color',
        'datetime_pending',
        'datetime_start',
        'datetime_finish'
    ];

    public function vehicle(){
        return $this->belongsTo(Vehicle::class, 'vehicle_id');
    }

    public function task(){
        return $this->belongsTo(Task::class, 'task_id');
    }

    public function state_pending_task(){
        return $this->belongsTo(StatePendingTask::class, 'state_pending_task_id');
    }

    public function groupTask(){
        return $this->belongsTo(GroupTask::class, 'group_task_id');
    }

    public function incidences(){
        return $this->belongsToMany(Incidence::class);
    }

    public function pending_task_canceled(){
        return $this->hasMany(PendingTaskCanceled::class);
    }

    public function vehicleExit(){
        return $this->hasOne(VehicleExit::class);
    }

    public function scopeByCampas($query, $ids){
        return $query->whereHas('vehicle.campa', function (Builder $builder) use($ids){
            return $builder->whereIn('id', $ids);
        });
    }

    public function scopePendingOrInProgress($query){
        return $query->where('state_pending_task_id', StatePendingTask::PENDING)
                ->orWhere('state_pending_task_id', StatePendingTask::IN_PROGRESS);
    }

    public function scopeCanSeeHomework($query, $userTypeId){
        return $query->whereHas('task.sub_state.type_users_app', function ($query) use($userTypeId) {
            return $query->where('type_user_app_id', $userTypeId);
        });
    }

    public function scopeByPlate($query, $plate){
        return $query->whereHas('vehicle', function (Builder $builder) use($plate) {
            return $builder->where('plate', $plate);
        });
    }

}
