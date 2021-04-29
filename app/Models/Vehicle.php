<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Campa;
use App\Models\Category;
use App\Models\State;
use App\Models\Request;
use App\Models\PendingTask;
use App\Models\GroupTask;
use App\Models\VehiclePicture;
use App\Models\Reservation;
use App\Models\Reception;
use App\Models\TradeState;

class Vehicle extends Model
{
    public function category(){
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function campa(){
        return $this->belongsTo(Campa::class, 'campa_id');
    }

    public function state(){
        return $this->belongsTo(State::class, 'state_id');
    }

    public function requests(){
        return $this->hasMany(Request::class, 'vehicle_id');
    }

    public function pending_tasks(){
        return $this->hasMany(PendingTask::class, 'vehicle_id');
    }

    public function group_tasks(){
        return $this->hasMany(GroupTask::class, 'vehicle_id');
    }

    public function vehicle_pictures(){
        return $this->hasMany(VehiclePicture::class, 'vehicle_id');
    }

    public function reservations(){
        return $this->hasMany(Reservation::class, 'vehicle_id');
    }

    public function receptions(){
        return $this->hasMany(Reception::class, 'vehicle_id');
    }

    public function trade_state(){
        return $this->belongsTo(TradeState::class, 'trade_state_id');
    }
}
