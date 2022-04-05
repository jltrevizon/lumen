<?php 

namespace App\Filters;

use EloquentFilter\ModelFilter;

class PendingAuthorizationFilter extends ModelFilter
{
    /**
    * Related Models that have ModelFilters as well as the method on the ModelFilter
    * As [relationMethod => [input_key1, input_key2]].
    *
    * @var array
    */
    public $relations = [];

    public function ids($ids)
    {
        return $this->whereIn('id', $ids);
    }

    public function vehicleIds($ids)
    {   
        return $this->whereIn('vehicle_id', $ids);
    }

    public function taskIds($ids)
    {
        return $this->whereIn('task_id', $ids);
    }

    public function damageIds($ids)
    {
        return $this->whereIn('damage_id', $ids);
    }

    public function stateAuthorizationIds($ids)
    {
        return $this->whereIn('state_authorization_id', $ids);
    }

    public function orderDesc($field){
        return $this->orderByDesc($field);
    }

    public function order($field){
        return $this->orderBy($field);
    }

}
