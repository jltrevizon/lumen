<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Campa;
use App\Models\ReservationTime;
use App\Models\Customer;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Company extends Model
{

    use HasFactory;

    protected $fillable = [
        'name',
        'tradename',
        'nif',
        'address',
        'location',
        'phone',
        'logo'
    ];

    public function campas(){
        return $this->hasMany(Campa::class, 'company_id');
    }

    public function reservation_times(){
        return $this->hasMany(ReservationTime::class, 'company_id');
    }

    public function customers(){
        return $this->hasMany(Customer::class, 'company_id');
    }

    public function users(){
        return $this->hasMany(User::class);
    }

    public function questions(){
        return $this->hasMany(Question::class);
    }

    public function defleetVariable(){
        return $this->hasOne(DefleetVariable::class);
    }

    public function states(){
        return $this->hasMany(State::class);
    }
}
