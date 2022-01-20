<?php 

namespace App\Filters;

use EloquentFilter\ModelFilter;

class StateFilter extends ModelFilter
{

    public function ids($ids){
        return $this->byIds($ids);
    }

    public function companies($ids){
        return $this->byCompany($ids);
    }

    public function types($ids){
        return $this->byType($ids);
    }

    /**
    * Related Models that have ModelFilters as well as the method on the ModelFilter
    * As [relationMethod => [input_key1, input_key2]].
    *
    * @var array
    */
    public $relations = [];
}
