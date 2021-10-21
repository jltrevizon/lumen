<?php 

namespace App\Filters;

use EloquentFilter\ModelFilter;

class IncidenceImageFilter extends ModelFilter
{

    public function ids($ids){
        return $this->byIds($ids);
    }

    public function incidenceIds($ids){
        return $this->byIncidenceIds($ids);
    }

    public function commentIds($ids){
        return $this->byCommentIds($ids);
    }

    /**
    * Related Models that have ModelFilters as well as the method on the ModelFilter
    * As [relationMethod => [input_key1, input_key2]].
    *
    * @var array
    */
    public $relations = [];
}
