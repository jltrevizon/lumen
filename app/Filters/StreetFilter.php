<?php 

namespace App\Filters;

use EloquentFilter\ModelFilter;

class StreetFilter extends ModelFilter
{

    public function ids($ids){
        return $this->byIds($ids);
    }

    public function zoneIds($ids){
        return $this->byZoneIds($ids);
    }

    public function name($name){
        return $this->byName($name);
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
