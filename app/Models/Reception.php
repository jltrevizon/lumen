<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Vehicle;
use EloquentFilter\Filterable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Reception extends Model
{
    use HasFactory, Filterable, SoftDeletes;

    protected $fillable = [
        'campa_id',
        'vehicle_id',
        'group_task_id',
        'finished',
        'has_accessories'
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
}
