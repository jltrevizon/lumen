<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Request as VehicleRequest;
use App\Models\Vehicle;
use App\Models\Transport;

class Reservation extends Model
{
    public function request(){
        return $this->belongsTo(VehicleRequest::class, 'request_id');
    }

    public function vehicle(){
        return $this->belongsTo(Vehicle::class, 'vehicle_id');
    }

    public function transport(){
        return $this->belongsTo(Reservation::class);
    }
}
