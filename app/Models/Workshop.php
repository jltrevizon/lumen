<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Workshop extends Model
{

    use HasFactory;

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
