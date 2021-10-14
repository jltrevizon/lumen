<?php

namespace App\Filters;

use EloquentFilter\ModelFilter;

class BudgetPendingTaskFilter extends ModelFilter
{
    public function pendingTasks($ids){
        return $this->byPendingTaskIds($ids);
    }

    public function stateBudgetPendingTasks($ids){
        return $this->byStateBudgetPendingTaskIds($ids);
    }

    public function vehiclePlate($plate){
        return $this->byPlate($plate);
    }
}
