<?php

namespace App\Filters;

use App\Filters\Base\BaseFilter\BaseFilter;
use EloquentFilter\ModelFilter;
use Illuminate\Database\Eloquent\Builder;

class VehicleFilter extends ModelFilter
{

    public function campas($ids)
    {
        return $this->campasIds($ids);
    }

    public function subStates($ids)
    {
        return $this->subStateIds($ids);
    }

    public function states($ids)
    {
        return $this->stateIds($ids);
    }

    public function plate($plate)
    {
        return $this->byPlate($plate);
    }

    public function brands($ids)
    {
        return $this->brandIds($ids);
    }

    public function vehicleModels($ids)
    {
        return $this->vehicleModelIds($ids);
    }

    public function categories($ids)
    {
        return $this->categoriesIds($ids);
    }

    public function tradeStates($ids)
    {
        return $this->byTradeStateIds($ids);
    }

    public function ubication($ids)
    {
        return $this->byUbication($ids);
    }

    public function readyDelivery($value)
    {
        return $this->byReadyDelivery($value);
    }

    public function statePendingTasks($ids){
        return $this->byStatePendingTasks($ids);
    }

    public function campaNull(){
        return $this->byCampaNull();
    }

}
