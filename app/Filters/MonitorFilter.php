<?php 

namespace App\Filters;

use EloquentFilter\ModelFilter;

class MonitorFilter extends ModelFilter
{

    public function createdAt($date){
        return $this->whereDate('created_at', $date);
    }

    /**
    * Related Models that have ModelFilters as well as the method on the ModelFilter
    * As [relationMethod => [input_key1, input_key2]].
    *
    * @var array
    */
    public $relations = [];
}
