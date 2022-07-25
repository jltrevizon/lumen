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

    public function budgetLastGroupTaskIds($ids){
        return $this->whereHas('lastGroupTask.pendingTasks', function(Builder $builder) use($ids){
            return $builder->whereHas('budgetPendingTasks', function ($query) use($ids){
                return $query->whereIn('state_budget_pending_task_id', $ids);
            })
            ->where('approved', true);
        });
    }

    public function vehicleModels($ids)
    {
        return $this->vehicleModelIds($ids);
    }

    public function categories($ids)
    {
        return $this->categoriesIds($ids);
    }

    public function groupTaskIds($ids){
        return $this->whereHas('groupTasks', function(Builder $builder) use($ids){
            return $builder->whereIn('id', $ids);
        });
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

    public function subStateNull(){
        return $this->bySubStateNull();
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

    public function whereHasBudgetPendingTaskByState($stateId){
        return $this->whereHas('pendingTask.budgetPendingTasks', fn (Builder $builder) => $builder->where('state_budget_pending_task_id', $stateId));
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

    public function lastReceptionCreatedAtFrom($dateTime)
    {
        return $this->whereHas('lastReception', function($query) use ($dateTime) {
            return $query->whereDate('created_at', '>=',$dateTime); 
        });
    }

    public function lastReceptionCreatedAtTo($dateTime)
    {
        return $this->whereHas('lastReception', function($query) use ($dateTime) {
            return $query->whereDate('created_at', '<=',$dateTime); 
        });
    }

    public function lastReceptionCreatedAt($dateTime)
    {
        return $this->whereHas('lastReception', function($query) use ($dateTime) {
            return $query->whereDate('created_at', $dateTime); 
        });
    }

    public function approvedPendingTasksNotNull($value)
    {
        if ($value) {
            $vehicle = Vehicle::whereHas('lastGroupTask', function($query) { 
                return $query->whereDoesntHave('approvedPendingTasks');
            })->get('id');
            $value = collect($vehicle)->map(function ($item){ return $item->id;})->toArray();
            return $this->whereNotIn('id', $value);
        }
    }

    public function withLastGroupTask($value)
    {
        return $this->whereRaw('
            id IN(
            SELECT 
                pt.vehicle_id 
            FROM 
                pending_tasks pt 
            WHERE 
                pt.state_pending_task_id is NOT NULL 
                AND pt.state_pending_task_id <> 3 
                AND pt.approved = 1 
                AND pt.group_task_id = (SELECT MAX(gt.id) FROM group_tasks gt WHERE gt.vehicle_id = pt.vehicle_id)
        )');
    }

    public function pendingTaskIds($value)
    {
        return $this->whereRaw('
            id IN(
            SELECT 
                pt.vehicle_id 
            FROM 
                pending_tasks pt 
            WHERE 
                pt.task_id IN('.implode(',', $value).')
                AND pt.group_task_id = (SELECT MAX(gt.id) FROM group_tasks gt WHERE gt.vehicle_id = pt.vehicle_id)
                AND pt.approved = 1 
                AND pt.state_pending_task_id IN(1, 2)
                AND pt.order = 1
            ORDER BY pt.state_pending_task_id desc, pt.order, pt.datetime_finish desc 
        )');
    }

    public function isDefleeting($value)
    {
        if($value){
            return $this->whereHas('lastReception.groupTask', fn ($builder) => $builder->whereNotNull('datetime_defleeting'));
        } else {
            return $this->whereHas('lastReception.groupTask', fn ($builder) => $builder->whereNull('datetime_defleeting'));
        }
    }

    public function hasDamage($value){
        return $this->whereHas('lastGroupTask.damages');
    }

    public function orderDesc($field){
        return $this->orderByDesc($field);
    }

    public function order($field){
        return $this->orderBy($field);
    }

}
