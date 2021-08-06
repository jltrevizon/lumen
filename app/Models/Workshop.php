<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Workshop extends Model
{

    protected $fillable = [
        'name',
        'cif',
        'address',
        'location',
        'province',
        'phone'
    ];

    public function orders(){
        return $this->hasMany(Order::class);
    }
}
