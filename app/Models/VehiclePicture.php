<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Vehicle;

class VehiclePicture extends Model
{
    public function vehicle(){
        return $this->belongsTo(Vehicle::class, 'vehicle_id');
    }
}
