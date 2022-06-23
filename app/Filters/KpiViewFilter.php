<?php 

namespace App\Filters;

use EloquentFilter\ModelFilter;

class KpiViewFilter extends ModelFilter
{

    public function ids($ids){
        return $this->byIds($ids);
    }

    public function year($value){
        return $this->where('in_year', $value)->where('out_year', $value);
    }

    public function yearIn($value){
        return $this->where('in_year', $value);
    }

    public function yearOut($value){
        return $this->where('out_year', $value);
    }
    
    public function stateIds($value){
        return $this->whereIn('state_id', $value);
    }

    public function subStateIds($value){
        return $this->whereIn('sub_state_id', $value);
    }

    public function typeModelOrderIds($value){
        return $this->whereIn('type_model_order_id', $value);
    }

    /**
    * Related Models that have ModelFilters as well as the method on the ModelFilter
    * As [relationMethod => [input_key1, input_key2]].
    *
    * @var array
    */
    public $relations = [];
}
