<?php 

namespace App\Filters;

use EloquentFilter\ModelFilter;

class HistoryLocationFilter extends ModelFilter
{

    public function vehicleIds($ids){
        return $this->whereIn('vehicle_id', $ids);
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

    /**
    * Related Models that have ModelFilters as well as the method on the ModelFilter
    * As [relationMethod => [input_key1, input_key2]].
    *
    * @var array
    */
    public $relations = [];
}
