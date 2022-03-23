<?php 

namespace App\Filters;

use EloquentFilter\ModelFilter;

class StateChangeFilter extends ModelFilter
{

    public function startDate($date){
        return $this->whereDate('created_at','>=',$date);
    }

    public function endDate($date){
        return $this->whereDate('created_at','<=' , $date);
    }

    /**
    * Related Models that have ModelFilters as well as the method on the ModelFilter
    * As [relationMethod => [input_key1, input_key2]].
    *
    * @var array
    */
    public $relations = [];
}
