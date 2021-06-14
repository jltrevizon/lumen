<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Region;
use App\Models\Campa;
use App\Models\Customer;

class Province extends Model
{

    protected $fillable = [
        'region_id',
        'province_code',
        'name'
    ];

    public function region(){
        return $this->belongsTo(Region::class, 'region_id');
    }

    public function campas(){
        return $this->hasMany(Campa::class, 'province_id');
    }

    public function customers(){
        return $this->hasMany(Customer::class, 'province_id');
    }
}
