<?php

namespace App\Models;

use EloquentFilter\Filterable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VehicleComment extends Model
{
    use HasFactory, Filterable;

    protected $table = 'vehicle_comments';

    protected $fillable = [
        'vehicle_id',
        'reception_id',
        'user_id',
        'description'
    ];

    public function vehicle(){
        return $this->belongsTo(Vehicle::class);
    }

    public function reception(){
        return $this->belongsTo(Reception::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }
}
