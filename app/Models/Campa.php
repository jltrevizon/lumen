<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Province;
use App\Models\Company;
use App\Models\Vehicle;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Campa extends Model
{

    use HasFactory;

    protected $filleable = [
        'company_id',
        'province_id',
        'name',
        'location',
        'address',
        'active',
    ];

    public function users(){
        return $this->belongsToMany(User::class);
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
