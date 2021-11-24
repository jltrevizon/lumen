<?php 

namespace App\Filters;

use EloquentFilter\ModelFilter;

class VehicleExitFilter extends ModelFilter
{

    public function ids($ids){
        return $this->whereIn('id', $ids);
    }

    public function vehicleIds($ids){
        return $this->whereIn('vehicle_id', $ids);
    }

    public function pendingTaskIds($ids){
        return $this->whereIn('pending_task_id', $ids);
    }

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
