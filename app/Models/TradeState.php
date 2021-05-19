<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Vehicle;

class TradeState extends Model
{
    public function vehicles(){
        return $this->hasMany(Vehicle::class, 'trade_state_id');
    }
}
