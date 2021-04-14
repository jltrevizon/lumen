<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Vehicle;
use App\Models\StateRequest;
use App\Models\TypeRequest;
use App\Models\Reservation;

class Request extends Model
{
    public function vehicle(){
        return $this->belongsTo(Vehicle::class, 'vehicle_id');
    }

    public function state_request(){
        return $this->belongsTo(StateRequest::class, 'state_request_id');
    }

    public function type_request(){
        return $this->belongsTo(TypeRequest::class, 'type_request_id');
    }

    public function reservation(){
        return $this->hasOne(Reservation::class, 'request_id');
    }
}
