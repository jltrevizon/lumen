<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TypeUserApp extends Model
{
    use HasFactory;

    const RESPONSABLE_CAMPA = 1;
    const OPERATOR_CAMPA = 2;
    const WORKSHOP_MECHANIC = 3;
    const WORKSHOP_CHAPA = 4;
    const FLEETS = 5;
    const WASHED = 6;
    const MOONS = 7;

    public function subStates(){
        return $this->belongsToMany(SubState::class);
    }

    public function users(){
        return $this->hasMany(User::class);
    }
}
