<?php

namespace App\Filters;

use EloquentFilter\ModelFilter;

class PendingTaskFilter extends ModelFilter
{
    public function vehicles($ids){
        return $this->byVehicleIds($ids);
    }

    public function tasks($ids){
        return $this->byTaskIds($ids);
    }

    public function statePendingTasks($ids){
        return $this->byStatePendingTaskIds($ids);
    }

    public function groupTasks($ids){
        return $this->byGroupTaskIds($ids);
    }

    public function ids($ids){
        return $this->byIds($ids);
    }

    public function taskIds($ids){
        return $this->byTaskIds($ids);
    }

}
