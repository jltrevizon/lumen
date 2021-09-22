<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DeliveryVehicle extends Model
{

    protected $fillable = [
        'vehicle_id',
        'data_delivery'
    ];

    public function vehicle(){
        return $this->belongsTo(Vehicle::class);
    }
}
