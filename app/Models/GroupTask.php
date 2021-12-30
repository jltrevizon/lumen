<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\PendingTask;
use App\Models\Vehicle;
use EloquentFilter\Filterable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class GroupTask extends Model
{

    use HasFactory, Filterable;

    protected $fillable = [
        'vehicle_id',
        'questionnaire_id',
        'approved'
    ];

    public function pendingTasks(){
        return $this->hasMany(PendingTask::class, 'group_task_id')
        ->where('approved', 1)
        ->orderByRaw("FIELD(state_pending_task_id,1, 2, 3, null) desc")
        ->orderBy('order');
    }

    public function approvedPendingTasks(){
        return $this->hasMany(PendingTask::class, 'group_task_id')
        ->where('approved', 1)
        ->whereNotNull('state_pending_task_id')
        ->where('state_pending_task_id', '<', 3)
        ->orderBy('order')
        ->orderBy('state_pending_task_id');

    }

    public function vehicle(){
        return $this->belongsTo(Vehicle::class, 'group_task_id');
    }

    public function questionnaire(){
        return $this->belongsTo(Questionnaire::class);
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
