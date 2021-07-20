<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Vehicle;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class VehiclePicture extends Model
{

    use HasFactory;

    public function vehicle(){
        return $this->belongsTo(Vehicle::class, 'vehicle_id');
    }
}
