<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Province;
use App\Models\Company;
use App\Models\Vehicle;


class Campa extends Model
{
    public function users(){
        return $this->hasMany(User::class, 'campa_id');
    }

    public function province(){
        return $this->belongsTo(Province::class, 'province_id');
    }

    public function company(){
        return $this->belongsTo(Company::class, 'company_id');
    }

    public function vehicles(){
        return $this->hasMany(Vehicle::class, 'campa_id');
    }
}
