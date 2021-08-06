<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{

    protected $fillable = [
        'vehicle_id',
        'workshop_id',
        'state_id',
        'type_model_order_id',
        'id_gsp'
    ];

    public function vehicle(){
        return $this->belongsTo(Vehicle::class);
    }

    public function workshop(){
        return $this->belongsTo(workshop::class);
    }

    public function state(){
        return $this->belongsTo(State::class);
    }

    public function typeModelOrder(){
        return $this->belongsTo(TypeModelOrder::class);
    }
}
