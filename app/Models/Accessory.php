<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Accessory extends Model
{
    use HasFactory;

    protected $fillable = [
        'reception_id',
        'vehicle_id',
        'name',
        'description',
        'mounted',
        'datetime_mounted',
        'datetime_unmounted'
    ];

    public function reception(){
        return $this->belongsTo(Reception::class);
    }

    public function vehicle(){
        return $this->belongsTo(Vehicle::class);
    }

}
