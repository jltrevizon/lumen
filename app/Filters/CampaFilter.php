<?php

namespace App\Filters;

use App\Models\Campa;
use App\Traits\CoincidenceFilterTrait;
use EloquentFilter\ModelFilter;

class CampaFilter extends ModelFilter
{
    use CoincidenceFilterTrait;

    public function ids($ids){
        return $this->byIds($ids);
    }

    public function companies($ids){
        return $this->byCompanies($ids);
    }

    public function provinces($ids){
        return $this->byProvinces($ids);
    }

    public function regions($ids){
        return $this->byRegions($ids);
    }

    public function name($name){
        return $this->byName($name);
    }

    public function orderDesc($field){
        return $this->orderByDesc($field);
    }

    public function order($field){
        return $this->orderBy($field);
    }

}
