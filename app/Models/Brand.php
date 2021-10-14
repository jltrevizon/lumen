<?php

namespace App\Models;

use EloquentFilter\Filterable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{

    use HasFactory, Filterable;

    protected $fillable = [
        'name'
    ];

    public function vehicleModels(){
        return $this->hasMany(VehicleModel::class);
    }

    public function scopeByIds($query, $ids){
        return $query->whereIn('id', $ids);
    }

    public function scopeByName($query, $name){
        return $query->where('name', 'like', "%$name%");
    }
}
