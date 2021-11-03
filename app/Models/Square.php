<?php

namespace App\Models;

use EloquentFilter\Filterable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Square extends Model
{
    
    use HasFactory, Filterable;

    protected $fillable = [
        'street_id',
        'vehicle_id',
        'name'
    ];

    public function street(){
        return $this->belongsTo(Street::class);
    }

    public function vehicle(){
        return $this->belongsTo(Vehicle::class);
    }

    public function scopeByIds($query, array $ids){
        return $query->whereIn('id', $ids);
    }

    public function scopeByStreetIds($query, array $ids){
        return $query->whereIn('street_id', $ids);
    }

    public function scopeByVehicleIds($query, array $ids){
        return $query->whereIn('vehicle_id', $ids);
    }

    public function scopeByName($query, string $name){
        return $query->where('name','like',"%$name%");
    }

    public function scopeByCampaIds($query, array $ids){
        return $query->whereHas('street.zone.campa', function (Builder $builder) use ($ids){
            return $builder->whereIn('id', $ids);
        });
    }

}
