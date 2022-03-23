<?php

namespace App\Models;

use EloquentFilter\Filterable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AccessoryType extends Model
{
    
    use HasFactory, Filterable;
    
    protected $fillable = [
        'description'
    ];

    public function accessories(){
        return $this->hasMany(Accessory::class);
    }

}
