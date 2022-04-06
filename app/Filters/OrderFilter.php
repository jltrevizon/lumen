<?php

namespace App\Filters;

use EloquentFilter\ModelFilter;

class OrderFilter extends ModelFilter
{
    public function ids($ids){
        return $this->byIds($ids);
    }

    public function states($ids){
        return $this->byStateIds($ids);
    }

    public function workshop($id){
        return $this->byWorkshopId($id);
    }

    public function vehiclePlate($plate){
        return $this->byVehiclePlate($plate);
    }

    public function orderDesc($field){
        return $this->orderByDesc($field);
    }

    public function order($field){
        return $this->orderBy($field);
    }

}
