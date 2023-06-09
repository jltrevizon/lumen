<?php

namespace App\Filters;

use EloquentFilter\ModelFilter;
use Illuminate\Database\Eloquent\Builder;


class HistoryLocationFilter extends ModelFilter
{

    public function vehicleIds($ids){
        return $this->whereIn('vehicle_id', $ids);
    }

    public function receptionId($reception_id){
        return $this->where('reception_id', $reception_id);
    }

    public function squareIds($ids){
        return $this->whereIn('square_id', $ids);
    }

    public function streetIds($ids){
        return $this->whereHas('square', function($query) use ($ids) {
            return $query->whereIn('street_id', $ids);
        });
    }

    public function zoneIds($ids){
        return $this->whereHas('square.street', function($query) use ($ids) {
            return $query->whereIn('zone_id', $ids);
        });
    }

    public function userIds($ids){
        return $this->whereIn('user_id', $ids);
    }

    public function createdAt($date){
        return $this->whereDate('created_at', $date);
    }

    public function vehiclePlate($plate){
        return $this->whereHas('vehicle', function(Builder $builder) use($plate){
            return $builder->where('plate','like',"%$plate%");
        });
    }

    public function vehicleCampaIds($ids){
        return $this->whereHas('vehicle', function(Builder $builder) use($ids){
            return $builder->whereIn('campa_id', $ids);
        });
    }

    public function orderDesc($field){
        return $this->orderByDesc($field);
    }

    public function order($field){
        return $this->orderBy($field);
    }

    public function whereHasVehicle($value){
        return $this->whereHas('vehicle');
    }


    /**
    * Related Models that have ModelFilters as well as the method on the ModelFilter
    * As [relationMethod => [input_key1, input_key2]].
    *
    * @var array
    */
    public $relations = [];
}
