<?php

namespace App\Models;

use App\Traits\CoincidenceFilterTrait;
use EloquentFilter\Filterable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VehicleModel extends Model
{
    use Filterable, CoincidenceFilterTrait;
    use HasFactory;

    protected $fillable = [
        'brand_id',
        'name'
    ];

    public function vehicles(){
        return $this->hasMany(Vehicle::class);
    }

    public function brand(){
        return $this->belongsTo(Brand::class);
    }

    public function scopeByIds($query, array $ids){
        return $query->whereIn('id', $ids);
    }

    public function scopeByName($query, $name){
        return $query->where('name','like',"%$name%");
    }

    public function scopeByBrand($query, int $brandId){
        return $query->where('brand_id', $brandId);
    }
}
