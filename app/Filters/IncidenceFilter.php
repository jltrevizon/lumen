<?php

namespace App\Filters;

use EloquentFilter\ModelFilter;

class IncidenceFilter extends ModelFilter
{

    public function ids($ids){
        return $this->byIds($ids);
    }

    public function resolved($resolved){
        return $this->byResolved($resolved);
    }

    public function vehicleIds($ids){
        return $this->byVehicleIds($ids);
    }

    public function read($read){
        return $this->byRead($read);
    }

    public function plate($plate){
        return $this->byPlate($plate);
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
