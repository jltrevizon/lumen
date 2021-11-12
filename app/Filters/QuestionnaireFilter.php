<?php 

namespace App\Filters;

use EloquentFilter\ModelFilter;

class QuestionnaireFilter extends ModelFilter
{

    public function ids($ids){
        return $this->whereIn('id', $ids);
    }

    public function userIds($ids){
        return $this->whereIn('user_id', $ids);
    }

    public function vehicleids($ids){
        return $this->whereIn('vehicle_id', $ids);
    }

    /**
    * Related Models that have ModelFilters as well as the method on the ModelFilter
    * As [relationMethod => [input_key1, input_key2]].
    *
    * @var array
    */
    public $relations = [];
}
