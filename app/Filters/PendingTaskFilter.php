<?php

namespace App\Filters;

use App\Models\State;
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

    public function campasIds($ids)
    {
        return $this->whereHas('vehicle', function(Builder $builder) use($ids){
            return $builder->whereIn('campa_id', $ids);
        });
    }

    public function withoutOrderOrOrderFinished($value) {
        return $this->whereHas('vehicle.orders', function(Builder $builder) {
            return $builder->where('state_id', State::FINISHED);
        })->orWhereDoesntHave('vehicle.orders');
    }

    public function withWorkshop($value) {
        return $this->whereHas('vehicle.orders', function(Builder $builder) use ($value) {
            return $builder->where('workshop_id', $value);
        });
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

    public function userStartIds($ids)
    {
        return $this->whereIn('user_start_id', $ids);
    }

    public function userEndIds($ids)
    {
        return $this->whereIn('user_end_id', $ids);
    }

}
