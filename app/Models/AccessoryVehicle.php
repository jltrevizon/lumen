<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AccessoryVehicle extends Model
{
 
    use HasFactory;

    protected $fillable = [
        'accessory_id',
        'vehicle_id'
    ];

}
