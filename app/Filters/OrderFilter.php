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
}
