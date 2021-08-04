<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Vehicle;
use App\Models\SubState;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class State extends Model
{

    use HasFactory;

    const AVAILABLE = 1;
    const WORKSHOP = 2;
    const PENDING_SALE_VO = 3;
    const NOT_AVAILABLE = 4;
    const DELIVERED = 5;
    const PRE_AVAILABLE = 6;

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
