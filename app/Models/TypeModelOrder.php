<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TypeModelOrder extends Model
{

    use HasFactory;

    const BIPI = 1;
    const REDRIVE = 2;
    const D2 = 3;
    const ALDFLEX = 4;
    const CARMARKET = 5;
    const DEVOLUTION = 6;
    const VO = 7;
    const VO_ENTREGADO = 8;

    protected $fillable = [
        'name'
    ];

    public function orders(){
        return $this->hasMany(Order::class);
    }
}
