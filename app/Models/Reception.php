<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Vehicle;
use EloquentFilter\Filterable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\DB;

class Reception extends Model
{
    use HasFactory, Filterable;

    protected $fillable = [
        'campa_id',
        'vehicle_id',
        'group_task_id',
        'finished',
        'has_accessories',
        'type_reception_id'
    ];

    protected $dates = [
        'deleted_at'
    ];

    public function vehicle(){
        return $this->belongsTo(Vehicle::class, 'vehicle_id');
    }

    public function typeModelOrder(){
        return $this->belongsTo(TypeModelOrder::class);
    }

    public function typeReception(){
        return $this->belongsTo(TypeReception::class);
    }

    public function accessories(){
        return $this->hasMany(Accessory::class);
    }

    public function vehiclePictures(){
        return $this->hasMany(VehiclePicture::class);
    }

    public function campa(){
        return $this->belongsTo(Campa::class);
    }

    public function groupTask(){
        return $this->belongsTo(GroupTask::class);
    }

    public function defleetingAndDelivery($value) {
        $vehicle_ids = collect(PendingTask::where('state_pending_task_id', 3)->where('task_id', 38)->whereRaw(DB::raw('vehicle_id in (SELECT v.id from vehicles v where v.sub_state_id = 8)'))->get('vehicle_id'))->map(function ($item){ return $item->vehicle_id;})->toArray();
        if ($value) {
            return $this->whereNotIn('vehicle_id', $vehicle_ids);
        }
        return $this->whereIn('vehicle_id', $vehicle_ids);
    }
}
