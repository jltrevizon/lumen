<?php

namespace App\Models;

use EloquentFilter\Filterable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Accessory extends Model
{
    use HasFactory, Filterable;

    protected $fillable = [
        'accessory_type_id',
        'name'
    ];

    public function accessoryType(){
        return $this->belongsTo(AccessoryType::class);
    }

    public function vehicles(){
        return $this->belongsToMany(Vehicle::class);
    }

    public function scopeByIds($query, array $ids){
        return $query->whereIn('id', $ids);
    }

}
