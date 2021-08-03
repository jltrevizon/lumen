<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Province;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Region extends Model
{

    use HasFactory;

    const ANDALUCIA = 1;
    const ARAGON = 2;
    const CANARIAS = 3;
    const CANTABRIA = 4;
    const CASTILLA_LEON = 5;
    const CASTILLA_LA_MANCHA = 6;
    const CATALUÑA = 7;
    const COMMUNITY_MADRID = 8;
    const COMMUNITY_VALENCIA = 9;
    const EXTREMADURA = 10;
    const GALICIA = 11;
    const BALEARES = 12;
    const LA_RIOJA = 13;
    const PAIS_VASCO = 14;
    const ASTURIAS = 15;
    const MURCIA = 16;
    const NAVARRA = 17;

    protected $fillable = [
        'name'
    ];

    public function provinces(){
        return $this->hasMany(Province::class, 'region_id');
    }
}
