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

    const ORDER_TASKS = [39, 11, 2, 3, 4, 41, 5, 6, 7, 8];

    protected $fillable = [
        'vehicle_id',
        'reception_id',
        'task_id',
        'question_answer_id',
        'campa_id',
        'state_pending_task_id',
        'type_model_order_id',
        'user_start_id',
        'user_end_id',
        'group_task_id',
        'damage_id',
        'duration',
        'order',
        'approved',
        'observations',
        'code_authorization',
        'created_from_checklist',
        'status_color',
        'datetime_pending',
        'datetime_start',
        'datetime_pause',
        'datetime_finish',
        'comment_state',
        'user_id'
    ];

    public function vehicle(){
        return $this->belongsTo(Vehicle::class);
    }

    public function typeModelOrder(){
        return $this->belongsTo(TypeModelOrder::class);
    }

    public function reception(){
        return $this->belongsTo(Reception::class);
    }

    public function lastDeliveryVehicle(){
        return $this->hasOne(DeliveryVehicle::class)->withTrashed()->ofMany([
            'pending_task_id' => 'max'
        ]);
    }

    public function lastDeliveredPendingTask(){
        return $this->belongsTo(PendingTask::class, 'last_delivered_pending_task_id', 'id');
    }

    public function questionAnswer(){
        return $this->belongsTo(QuestionAnswer::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function task(){
        return $this->belongsTo(Task::class);
    }

    public function campa(){
        return $this->belongsTo(Campa::class);
    }

    public function statePendingTask(){
        return $this->belongsTo(StatePendingTask::class);
    }

    public function groupTask(){
        return $this->belongsTo(GroupTask::class);
    }

    public function damage(){
        return $this->belongsTo(Damage::class);
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

    public function estimatedDates(){
        return $this->hasMany(EstimatedDate::class);
    }

    public function lastEstimatedDate(){
        return $this->hasOne(EstimatedDate::class)->ofMany([
            'id' => 'max'
        ]);
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
