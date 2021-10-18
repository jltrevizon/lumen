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
        'approved'
    ];

    public function pendingTasks(){
        return $this->hasMany(PendingTask::class, 'group_task_id');
    }

    public function vehicle(){
        return $this->belongsTo(Vehicle::class, 'group_task_id');
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
