<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Campa;
use App\Models\ReservationTime;
use App\Models\Customer;

class Company extends Model
{
    public function campas(){
        return $this->hasMany(Campa::class, 'company_id');
    }

    public function reservation_times(){
        return $this->hasMany(ReservationTime::class, 'company_id');
    }

    public function customers(){
        return $this->hasMany(Customer::class, 'company_id');
    }
}
