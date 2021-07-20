<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Vehicle;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TradeState extends Model
{

    use HasFactory;

    public function vehicles(){
        return $this->hasMany(Vehicle::class, 'trade_state_id');
    }
}
