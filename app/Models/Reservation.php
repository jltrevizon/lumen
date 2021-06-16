<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Request as VehicleRequest;
use App\Models\Vehicle;
use App\Models\Transport;

class Reservation extends Model
{

    protected $fillable = [
        'request_id',
        'vehicle_id',
        'reservation_time',
        'dni',
        'order',
        'contract',
        'planned_reservation',
        'pickup_by_customer',
        'transport_id',
        'actual_date',
        'campa_id',
        'type_reservation_id',
        'active'
    ];

    public function request(){
        return $this->belongsTo(VehicleRequest::class, 'request_id');
    }

    public function vehicle(){
        return $this->belongsTo(Vehicle::class, 'vehicle_id');
    }

    public function transport(){
        return $this->belongsTo(Transport::class, 'transport_id');
    }
}
