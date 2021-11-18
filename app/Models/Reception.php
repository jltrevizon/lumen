<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Vehicle;
use EloquentFilter\Filterable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Reception extends Model
{
    use HasFactory, Filterable;

    protected $fillable = [
        'campa_id',
        'vehicle_id',
        'finished',
        'has_accessories'
    ];

    public function vehicle(){
        return $this->belongsTo(Vehicle::class, 'vehicle_id');
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
}
