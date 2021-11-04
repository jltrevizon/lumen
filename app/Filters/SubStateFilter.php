<?php 

namespace App\Filters;

use EloquentFilter\ModelFilter;

class SubStateFilter extends ModelFilter
{

    public function stateIds($ids){
        return $this->byStateIds($ids);
    }

    /**
    * Related Models that have ModelFilters as well as the method on the ModelFilter
    * As [relationMethod => [input_key1, input_key2]].
    *
    * @var array
    */
    public $relations = [];
}
