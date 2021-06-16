<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Vehicle;
use App\Models\SubState;

class State extends Model
{

    protected $fillable = [
        'name'
    ];

    public function vehicles(){
        return $this->hasMany(Vehicle::class, 'state_id');
    }

    public function sub_states(){
        return $this->hasMany(SubState::class, 'state_id');
    }
}
