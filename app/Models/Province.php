<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Region;
use App\Models\Campa;

class Province extends Model
{
    public function region(){
        return $this->belongsTo(Region::class, 'region_id');
    }

    public function campas(){
        return $this->hasMany(Campa::class, 'campa_id');
    }
}
