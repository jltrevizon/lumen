<?php

namespace App\Models;

use EloquentFilter\Filterable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DeliveryVehicle extends Model
{

    use HasFactory, Filterable;

    protected $fillable = [
        'vehicle_id',
        'data_delivery'
    ];

    public function vehicle(){
        return $this->belongsTo(Vehicle::class);
    }
}
