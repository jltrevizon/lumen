<?php

namespace App\Filters;

use App\Filters\Base\BaseFilter\BaseFilter;
use App\Models\Role;
use EloquentFilter\ModelFilter;
use Illuminate\Database\Eloquent\Builder;

class VehicleFilter extends ModelFilter
{
    public function ids($ids)
    {
        return $this->byIds($ids);
    }

    public function campas($ids)
    {
        return $this->campasIds($ids);
    }

    public function companyIds($ids){
        return $this->byCompanies($ids);
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

    public function typeModelOrderIds($ids){
        return $this->byTypeModelOrderIds($ids);
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

    public function whereHasBudgetPendingTask(){
        return $this->byWhereHasBudgetPendingTask();
    }

    public function byUserRole($roleId){
        return $this->byRole($roleId);
    }

    public function hasGroupTaskUnapproved($value){
        return $this->byHasGroupTaskUnapproved($value);
    }

    public function hasOrderNotFinish($value){
        return $this->byHasOrderNotFinish($value);
    }

    public function taskIds($ids){
        return $this->byTaskIds($ids);
    }

    public function pendingTaskDateTimeStartFrom($dateTime)
    {
        return $this->whereHas('pendingTasks', function($query) use ($dateTime) {
            return $query->whereDate('datetime_start','>=', $dateTime); 
        });
    }

    public function pendingTaskDateTimeStartTo($dateTime)
    {
        return $this->whereHas('pendingTasks', function($query) use ($dateTime) {
            return $query->whereDate('datetime_start','<=', $dateTime); 
        });
    }

    public function pendingTaskDateTimeEndFrom($dateTime)
    {
        return $this->whereHas('pendingTasks', function($query) use ($dateTime) {
            return $query->whereDate('datetime_end','>=', $dateTime); 
        });
    }

    public function pendingTaskDateTimeEndTo($dateTime)
    {
        return $this->whereHas('pendingTasks', function($query) use ($dateTime) {
            return $query->whereDate('datetime_end','<=', $dateTime); 
        });
    }

    public function pendingTaskDateTimePendingFrom($dateTime)
    {
        return $this->whereHas('pendingTasks', function($query) use ($dateTime) {
            return $query->whereDate('datetime_pending','>=', $dateTime); 
        });
    }

    public function pendingTaskDateTimePendingTo($dateTime)
    {
        return $this->whereHas('pendingTasks', function($query) use ($dateTime) {
            return $query->whereDate('datetime_pending','<=', $dateTime); 
        });
    }

}
