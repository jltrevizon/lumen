<?php 

namespace App\Filters;

use EloquentFilter\ModelFilter;

class DamageImageFilter extends ModelFilter
{

    public function ids($ids){
        return $this->byIds($ids);
    }

    public function userIds($ids){
        return $this->byUserIds($ids);
    }

    public function vehicleIds($ids){
        return $this->byVehicleIds($ids);
    }

    public function plate($plate){
        return $this->byPlate($plate);
    }

    /**
    * Related Models that have ModelFilters as well as the method on the ModelFilter
    * As [relationMethod => [input_key1, input_key2]].
    *
    * @var array
    */
    public $relations = [];
}
