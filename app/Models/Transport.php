<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Reservation;

class Transport extends Model
{

    protected $fillable = [
        'name'
    ];

    public function reservations(){
        return $this->hasMany(Reservation::class, 'transport_id');
    }
}
