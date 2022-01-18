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

    public function createdAt($date){
        return $this->whereDate('created_at', $date);
    }

    public function createdAtFrom($dateTime)
    {
        return $this->whereDate('created_at','>=', $dateTime);
    }

    public function createdAtTo($dateTime)
    {
        return $this->whereDate('created_at','<=', $dateTime);
    }
}
