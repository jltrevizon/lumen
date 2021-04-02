<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Vehicle;
use App\Models\SubState;

class State extends Model
{
    public function vehicles(){
        return $this->hasMany(Vehicle::class, 'vehicle_id');
    }

    public function sub_states(){
        return $this->hasMany(SubState::class, 'sub_state_id');
    }
}
