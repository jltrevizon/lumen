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
    const PENDING_TEST_DINAMIC = 7;
    const PENDING_INITIAL_CHECK = 8;
    const PENDING_BUDGET = 9;
    const PENDING_AUTHORIZATION = 10;
    const IN_REPAIR = 11;
    const PENDING_CERTIFICATED = 12;
    const PENDING_FINAL_CHECK = 13;
    const FINISHED = 14;

    protected $fillable = [
        'name'
    ];

    public function vehicles(){
        return $this->hasMany(Vehicle::class, 'state_id');
    }

    public function sub_states(){
        return $this->hasMany(SubState::class, 'state_id');
    }

    public function orders(){
        return $this->hasMany(Order::class);
    }
}
