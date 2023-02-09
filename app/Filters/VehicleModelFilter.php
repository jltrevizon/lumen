<?php

namespace App\Filters;

use App\Traits\CoincidenceFilterTrait;
use EloquentFilter\ModelFilter;

class VehicleModelFilter extends ModelFilter
{
    use CoincidenceFilterTrait;

    public function ids($ids){
        return $this->byIds($ids);
    }

    public function name($name){
        return $this->byName($name);
    }
    public function brands($ids){
        return $this->byBrands($ids);
    }

}
