<?php 

namespace App\Filters;

use EloquentFilter\ModelFilter;

class SquareFilter extends ModelFilter
{

    public function ids($ids){
        return $this->byIds($ids);
    }

    public function streetIds($ids){
        return $this->byStreetIds($ids);
    }

    public function vehicleIds($ids){
        return $this->byVehicleIds($ids);
    }

    public function name($ids){
        return $this->byName($ids);
    }

    /**
    * Related Models that have ModelFilters as well as the method on the ModelFilter
    * As [relationMethod => [input_key1, input_key2]].
    *
    * @var array
    */
    public $relations = [];
}
