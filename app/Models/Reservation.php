<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Request as VehicleRequest;
use App\Models\Vehicle;

class Reservation extends Model
{
    public function request(){
        return $this->hasOne(VehicleRequest::class, 'request_id');
    }

    public function vehicle(){
        return $this->belongsTo(Vehicle::class, 'vehicle_id');
    }
}
