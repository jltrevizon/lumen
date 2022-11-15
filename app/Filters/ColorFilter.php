<?php 

namespace App\Filters;

use EloquentFilter\ModelFilter;

class ColorFilter extends ModelFilter
{

    public function ids($ids){
        return $this->byIds($ids);
    }

    public function name($name){
        return $this->byName($name);
    }

    public function nameNull($value) {
        if (!$value) {
            return $this->whereNotNull('name');
        } else {
            return $this->whereNull('name');
        }
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
