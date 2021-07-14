<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Vehicle;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Reception extends Model
{
    use HasFactory;

    public function vehicle(){
        return $this->belongsTo(Vehicle::class, 'vehicle_id');
    }

    public function accessories(){
        return $this->hasMany(Accessory::class);
    }

    public function vehicle_pictures(){
        return $this->hasMany(VehiclePicture::class);
    }
}
