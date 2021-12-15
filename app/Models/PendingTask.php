<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Vehicle;
use App\Models\Task;
use App\Models\StatePendingTask;
use App\Models\GroupTask;
use App\Models\Incidence;
use EloquentFilter\Filterable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PendingTask extends Model
{

    use HasFactory, Filterable;

    protected $fillable = [
        'vehicle_id',
        'task_id',
        'state_pending_task_id',
        'user_start_id',
        'user_end_id',
        'group_task_id',
        'duration',
        'order',
        'approved',
        'observations',
        'code_authorization',
        'status_color',
        'datetime_pending',
        'datetime_start',
        'datetime_finish'
    ];

    public function vehicle(){
        return $this->belongsTo(Vehicle::class);
    }

    public function task(){
        return $this->belongsTo(Task::class);
    }

    public function statePendingTask(){
        return $this->belongsTo(StatePendingTask::class);
    }

    public function groupTask(){
        return $this->belongsTo(GroupTask::class);
    }

    public function incidences(){
        return $this->belongsToMany(Incidence::class);
    }

    public function pendingTaskCanceled(){
        return $this->hasMany(PendingTaskCanceled::class);
    }

    public function vehicleExit(){
        return $this->hasOne(VehicleExit::class);
    }

    public function operations(){
        return $this->hasMany(Operation::class);
    }

    public function budgetPendingTasks(){
        return $this->hasMany(BudgetPendingTask::class);
    }

    public function userStart(){
        return $this->belongsTo(User::class, 'user_start_id');
    }

    public function userEnd(){
        return $this->belongsTo(User::class, 'user_end_id');
    }

    public function scopeByCampas($query, array $ids){
        return $query->whereHas('vehicle.campa', function (Builder $builder) use($ids){
            return $builder->whereIn('id', $ids);
        });
    }

    public function scopePendingOrInProgress($query){
        return $query->where('state_pending_task_id', StatePendingTask::PENDING)
                ->orWhere('state_pending_task_id', StatePendingTask::IN_PROGRESS);
    }

    public function scopeCanSeeHomework($query, int $userTypeId){
        return $query->whereHas('task.subState.type_users_app', function ($query) use($userTypeId) {
            return $query->where('type_user_app_id', $userTypeId);
        });
    }

    public function scopeByPlate($query, string $plate){
        return $query->whereHas('vehicle', function (Builder $builder) use($plate) {
            return $builder->where('plate', $plate);
        });
    }

    public function scopeByVehicleIds($query, array $ids){
        return $query->whereIn('vehicle_id', $ids);
    }

    public function scopeByTaskIds($query, array $ids){
        return $query->whereIn('task_id', $ids);
    }

    public function scopeByStatePendingTaskIds($query,  array $ids){
        return $query->whereIn('state_pending_task_id', $ids);
    }

    public function scopeByGroupTaskIds($query,  array $ids){
        return $query->whereIn('group_task_id', $ids);
    }

    public function scopeByIds($query, array $ids){
        return $query->whereIn('id', $ids);
    }

    public function scopeByApproved($query, int $approved){
        return $query->where('approved', $approved);
    }

    /**
     * Scope a query to only include the last n days records
     *
     * @param  \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeWhereDateBetween($query,$fieldName,$fromDate,$todate)
    {
        return $query->whereDate($fieldName,'>=',$fromDate)->whereDate($fieldName,'<=',$todate);
    }
}
