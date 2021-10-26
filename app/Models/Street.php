<?php

namespace App\Models;

use EloquentFilter\Filterable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Street extends Model
{
    
    use HasFactory, Filterable;

    protected $fillable = [
        'zone_id',
        'name'
    ];

    public function zone(){
        return $this->belongsTo(Zone::class);
    }

    public function scopeByIds($query, array $ids){
        return $query->whereIn('id', $ids);
    }

    public function scopeByZoneIds($query, array $ids){
        return $query->whereIn('zone_id', $ids);
    }

    public function scopeByName($query, string $name){
        return $query->where('name','like',"%$name%");
    }

}
