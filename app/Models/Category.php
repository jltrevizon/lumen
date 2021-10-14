<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Vehicle;
use EloquentFilter\Filterable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Category extends Model
{

    use HasFactory, Filterable;

    protected $fillable = [
        'name',
        'description'
    ];

    public function vehicles(){
        return $this->hasMany(Vehicle::class, 'category_id');
    }

    public function scopeByIds($query, array $ids){
        return $query->whereIn('id', $ids);
    }

    public function scopeByName($query, $name){
        return $query->where('name','like',"%$name%");
    }
}
