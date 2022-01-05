<?php

namespace App\Filters;

use App\Filters\Base\BaseFilter\BaseFilter;
use App\Models\Role;
use EloquentFilter\ModelFilter;
use Illuminate\Database\Eloquent\Builder;
use App\Models\Vehicle;


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

    public function createdAt($date){
        return $this->whereDate('created_at', $date);
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

    public function budgetPendingTaskIds($ids){
        return $this->byBudgetPendingTaskIds($ids);
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

    public function subStatePendingTasks($ids){
        return $this->bySubStatePendingTasks($ids);
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

    public function hasOrdersStateIds($value){
        return $this->byHasOrdersStateIds($value);
    }

    public function taskIds($ids){
        return $this->byTaskIds($ids);
    }

    public function taskSubStatesIds($ids){
        return $this->byTaskSubStatesIds($ids);
    }

    public function taskStatesIds($ids){
        return $this->byTaskStatesIds($ids);
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

    public function approvedPendingTasksNotNull($value)
    {
        if ($value) {
            $vehicle = Vehicle::whereHas('lastGroupTask', function($query) { 
                return $query->whereDoesntHave('approvedPendingTasks');
            })->get('id');
            $value = collect($vehicle)->map(function ($item){ return $item->id;})->toArray();
            return $this->whereHas('pendingTasks', function($query) use ($value) {
                return $query->whereNotIn('vehicle_id', $value); 
            });
        }
    }

    public function lastGroupTaskFirstPendingTaskIds($value)
    {
        if ($value) {
            $vehicle = Vehicle::whereHas('lastGroupTask.approvedPendingTasks', function(Builder $builder) use ($value){
                return $builder->whereNotIn('task_id', $value);
            })->get('id');
            $value = collect($vehicle)->map(function ($item){ return $item->id;})->toArray();
            return $this->whereHas('pendingTasks', function($query) use ($value) {
                return $query->whereNotIn('vehicle_id', $value); 
            });
        }
    }

}
