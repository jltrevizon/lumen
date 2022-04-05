<?php

namespace App\Filters;

use EloquentFilter\ModelFilter;

class TaskFilter extends ModelFilter
{
    public function typeTasks($ids)
    {
        return $this->byTypeTasks($ids);
    }

    public function subStates($ids)
    {
        return $this->bySubStates($ids);
    }

    public function ids($ids){
        return $this->byIds($ids);
    }

    public function companies($ids){
        return $this->byCompany($ids);
    }

    public function orderDesc($field){
        return $this->orderByDesc($field);
    }

    public function order($field){
        return $this->orderBy($field);
    }

}
