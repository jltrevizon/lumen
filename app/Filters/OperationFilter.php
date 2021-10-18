<?php 

namespace App\Filters;

use EloquentFilter\ModelFilter;

class OperationFilter extends ModelFilter
{

    public function ids($ids){
        return $this->byIds($ids);
    }

    public function vehicleIds($ids)
    {
        return $this->byVehicleIds($ids);
    }

    public function pendingTaskIds($ids)
    {
        return $this->byPedingTaskIds($ids);
    }

    public function operationTypeIds($ids){
        return $this->byOperationTypeIds($ids);
    }

    /**
    * Related Models that have ModelFilters as well as the method on the ModelFilter
    * As [relationMethod => [input_key1, input_key2]].
    *
    * @var array
    */
    public $relations = [];
}
