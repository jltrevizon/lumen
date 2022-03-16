<?php 

namespace App\Filters;

use EloquentFilter\ModelFilter;

class CompanyFilter extends ModelFilter
{

    public function ids($ids){
        return $this->byIds($ids);
    }

    public function name($name){
        return $this->byName($name);
    }

    public function nif($nif){
        return $this->byNif($nif);
    }

    public function phone($phone){
        return $this->byPhone($phone);
    }

    /**
    * Related Models that have ModelFilters as well as the method on the ModelFilter
    * As [relationMethod => [input_key1, input_key2]].
    *
    * @var array
    */
    public $relations = [];
}
