<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Vehicle;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class VehiclePicture extends Model
{

    use HasFactory;

    protected $fillable = [
        'vehicle_id',
        'user_id',
        'reception_id',
        'url',
        'place',
        'latitude',
        'longitude',
        'active'
    ];

    public function vehicle(){
        return $this->belongsTo(Vehicle::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function reception(){
        return $this->belongsTo(Reception::class)->withTrashed();
    }
}
