<?php

namespace App\Filters;

use EloquentFilter\ModelFilter;

class BudgetPendingTaskFilter extends ModelFilter
{
    public function pendingTasks($ids){
        return $this->byPendingTaskIds($ids);
    }

    public function taskIds($ids){
        return $this->byTaskIds($ids);
    }

    public function stateBudgetPendingTasks($ids){
        return $this->byStateBudgetPendingTaskIds($ids);
    }

    public function campaIds($ids){
        return $this->whereIn('campa_id', $ids);
    }

    public function roleIds($ids){
        return $this->whereIn('role_id', $ids);
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

    public function orderDesc($field){
        return $this->orderByDesc($field);
    }

    public function order($field){
        return $this->orderBy($field);
    }

    public function hasVehicle($value) {
        return $this->has('pendingTask.vehicle');
    }

}
