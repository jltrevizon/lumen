<?php

namespace App\Models;

use EloquentFilter\Filterable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TypeReception extends Model
{
    use HasFactory, Filterable;
    
    const CKECK = 1;
    const CHECK_PENDING = 2;

    protected $fillable = [
        'name'
    ];

    public function repections(){
        return $this->hasMany(Reception::class);
    }

}
