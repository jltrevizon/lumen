<?php 

namespace App\Filters;

use EloquentFilter\ModelFilter;

class DefleetVariableFilter extends ModelFilter
{

    public function companyIds($ids){
        return $this->byCompany($ids);
    }

    /**
    * Related Models that have ModelFilters as well as the method on the ModelFilter
    * As [relationMethod => [input_key1, input_key2]].
    *
    * @var array
    */
    public $relations = [];
}
