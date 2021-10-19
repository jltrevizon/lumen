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

    /**
    * Related Models that have ModelFilters as well as the method on the ModelFilter
    * As [relationMethod => [input_key1, input_key2]].
    *
    * @var array
    */
    public $relations = [];
}
