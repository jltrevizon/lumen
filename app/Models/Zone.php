<?php

namespace App\Models;

use EloquentFilter\Filterable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Zone extends Model
{
    
    use HasFactory, Filterable;
    
    protected $fillable = [
        'name'
    ];

    public function streets(){
        return $this->hasMany(Street::class);
    }

    public function scopeByIds($query, array $ids){
        return $query->whereIn('id', $ids);
    }

    public function scopeByName($query, string $name){
        return $query->where('name','like',"%$name%");
    }

}
