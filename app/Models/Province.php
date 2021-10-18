<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Region;
use App\Models\Campa;
use App\Models\Customer;
use EloquentFilter\Filterable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Province extends Model
{

    use HasFactory, Filterable;

    protected $fillable = [
        'region_id',
        'province_code',
        'name'
    ];

    public function region(){
        return $this->belongsTo(Region::class, 'region_id');
    }

    public function campas(){
        return $this->hasMany(Campa::class, 'province_id');
    }

    public function customers(){
        return $this->hasMany(Customer::class, 'province_id');
    }

    public function scopeByIds($query, array $ids){
        return $query->whereIn('id', $ids);
    }

    public function scopeByRegionIds($query, array $ids){
        return $query->whereIn('region_id', $ids);
    }

    public function scopeByProvinceCode($query, string $code){
        return $query->where('province_code','like',"%$code%");
    }

    public function scopeByName($query, string $name){
        return $query->where('name','like',"%$name%");
    }
}
