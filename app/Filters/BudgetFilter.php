<?php 

namespace App\Filters;

use EloquentFilter\ModelFilter;

class BudgetFilter extends ModelFilter
{

    public function ids($ids){
        return $this->byIds($ids);
    }

    public function vehicleIds($ids){
        return $this->byVehicleIds($ids);
    }

    public function orderIds($ids){
        return $this->byOrderIds($ids);
    }

    public function orderDesc($field){
        return $this->orderByDesc($field);
    }

    public function order($field){
        return $this->orderBy($field);
    }


    /**
    * Related Models that have ModelFilters as well as the method on the ModelFilter
    * As [relationMethod => [input_key1, input_key2]].
    *
    * @var array
    */
    public $relations = [];
}
