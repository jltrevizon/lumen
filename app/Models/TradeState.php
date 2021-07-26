<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Vehicle;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TradeState extends Model
{

    use HasFactory;

    const RESERVED = 1;
    const PRE_RESERVED = 2;
    const RESERVED_PRE_DELIVERY = 3;
    const REQUEST_DEFLEET = 4;

    public function vehicles(){
        return $this->hasMany(Vehicle::class, 'trade_state_id');
    }
}
