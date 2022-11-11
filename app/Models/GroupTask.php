<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\PendingTask;
use App\Models\Vehicle;
use EloquentFilter\Filterable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\DB;

class GroupTask extends Model
{

    use HasFactory, Filterable;

    protected $fillable = [
        'vehicle_id',
        'questionnaire_id',
        'approved',
        'approved_available',
        'datetime_approved',
        'datetime_defleeting'
    ];

    public function pendingTasks(){
        return $this->hasMany(PendingTask::class, 'group_task_id')
        ->where('approved', 1)
        ->orderBy('state_pending_task_id', 'desc')
        ->orderBy('order')
        ->orderBy('datetime_finish', 'desc');
    }

    public function allPendingTasks() {
        return $this->hasMany(PendingTask::class, 'group_task_id')
        ->orderBy('state_pending_task_id', 'desc')
        ->orderBy('order')
        ->orderBy('datetime_finish', 'desc');
    }

    public function approvedPendingTasks(){
        return $this->hasMany(PendingTask::class, 'group_task_id')
        ->where('approved', true)
        ->where(function ($query) {
            $query->whereNotIn('state_pending_task_id',[StatePendingTask::FINISHED, StatePendingTask::CANCELED])
                ->orWhereNull('state_pending_task_id');
        })
        ->orderBy('state_pending_task_id', 'desc')
        ->orderBy('order')
        ->orderBy('datetime_finish', 'desc');
    }

    public function defaultOrderApprovedPendingTasks(){
        return $this->hasMany(PendingTask::class, 'group_task_id')
        ->where('approved', true)
        ->where(function ($query) {
            $query->where('state_pending_task_id', '<>', StatePendingTask::FINISHED)
                ->orWhereNull('state_pending_task_id');
        })
        ->orderByRaw('FIELD(task_id,'.implode(',',PendingTask::ORDER_TASKS).') desc');
        // ->orderBy('state_pending_task_id', 'desc')
        // ->orderBy('order')
        // ->orderBy('datetime_finish', 'desc');
    }

    public function allApprovedPendingTasks(){
        return $this->hasMany(PendingTask::class)
            ->where('approved', 1)
            ->selectRaw('*, (CASE WHEN pending_tasks.order > 0 THEN pending_tasks.order Else 100000000000 END) as order_str')
            ->orderByRaw('order_str asc')
            ->orderBy('datetime_finish', 'desc');
    }

    public function lastPendingTaskApproved(){
        return $this->hasMany(PendingTask::class)
            ->where('approved', true)
            ->orderBy('state_pending_task_id', 'desc')
            ->orderBy('order')
            ->orderBy('datetime_finish', 'desc');
    }

    public function lastPendingTaskWithState(){
        return $this->hasOne(PendingTask::class)
            ->where('approved', true)
            ->where(function ($query) {
                $query->where('state_pending_task_id', StatePendingTask::PENDING)
                ->orWhere('state_pending_task_id', StatePendingTask::IN_PROGRESS);
            });       
    }

    public function lastTaskWithState(){
        return $this->hasOne(PendingTask::class)
            ->where('approved', true)
            ->where(function ($query) {
                $query->where('state_pending_task_id', StatePendingTask::PENDING)
                ->orWhere('state_pending_task_id', StatePendingTask::IN_PROGRESS)
                ->orWhere('state_pending_task_id', StatePendingTask::FINISHED);
            });       
    }

    public function lastChangeState(){
        return $this->hasOne(PendingTask::class)
            ->where('approved', true)
            ->whereIn('state_pending_task_id', [StatePendingTask::PENDING, StatePendingTask::IN_PROGRESS, StatePendingTask::FINISHED])
            ->whereNotNull('last_change_state');            
    }

    public function lastChangeSubState(){
        return $this->hasOne(PendingTask::class)
            ->where('approved', true)
            ->whereNotNull('last_change_sub_state');            
    }

    public function vehicle(){
        return $this->belongsTo(Vehicle::class, 'vehicle_id');
    }

    public function typeModelOrder(){
        return $this->belongsTo(TypeModelOrder::class);
    }

    public function damages(){
        return $this->hasMany(Damage::class);
    }

    public function questionnaire(){
        return $this->belongsTo(Questionnaire::class);
    }

    public function reception(){
        return $this->hasOne(Reception::class);
    }

    public function scopeByIds($query, array $ids){
        return $query->whereIn('id', $ids);
    }

    public function scopeByVehicleIds($query, array $ids){
        return $query->whereIn('vehicle_id', $ids);
    }

    public function scopeByApproved($query, int $approved){
        return $query->where('approved', $approved);
    }

}
