<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Reservation;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Transport extends Model
{

    use HasFactory;

    protected $fillable = [
        'name'
    ];

    public function reservations(){
        return $this->hasMany(Reservation::class, 'transport_id');
    }
}
