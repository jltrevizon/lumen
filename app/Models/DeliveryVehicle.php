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
        'campa_id',
        'data_delivery'
    ];

    protected $casts = [
    	'vehicle_id' => 'integer',
    	'data_delivery' => 'json'
    ];

    public function vehicle(){
        return $this->belongsTo(Vehicle::class);
    }
}
