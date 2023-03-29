<?php 

namespace App\Filters;

use EloquentFilter\ModelFilter;
use Illuminate\Database\Eloquent\Builder;

class AccessoryVehicleFilter extends ModelFilter
{

    public function ids($ids){
        return $this->byIds($ids);
    }

    public function accessoryIds($ids){
        return $this->whereIn('accessory_id', $ids);
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
