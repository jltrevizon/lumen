<?php

namespace App\Filters;

use EloquentFilter\ModelFilter;
use Illuminate\Database\Eloquent\Builder;

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

    public function vehiclePlate($plate){
        return $this->whereHas('vehicle', function(Builder $builder) use($plate){
            return $builder->where('plate','like',"%$plate%");
        });
    }

    public function dateTimeStartFrom($dateTime)
    {
        return $this->whereDate('datetime_start','>=', $dateTime);
    }

    public function dateTimeStartTo($dateTime)
    {
        return $this->whereDate('datetime_start','<=', $dateTime);
    }

    public function dateTimeEndFrom($dateTime)
    {
        return $this->whereDate('datetime_finish','>=', $dateTime);
    }

    public function dateTimeEndTo($dateTime)
    {
        return $this->whereDate('datetime_finish','<=', $dateTime);
    }

    public function dateTimePendingFrom($dateTime)
    {
        return $this->whereDate('datetime_pending','>=', $dateTime);
    }

    public function dateTimePendingTo($dateTime)
    {
        return $this->whereDate('datetime_pending','<=', $dateTime);
    }

}
