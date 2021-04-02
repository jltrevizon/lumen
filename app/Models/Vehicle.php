<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Campa;
use App\Models\Category;
use App\Models\state;
use App\Models\Request;
use App\Models\PendingTask;
use App\Models\GroupTask;

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
}
