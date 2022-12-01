<?php

namespace App\Filters;

use App\Models\Campa;
use EloquentFilter\ModelFilter;

class CampaFilter extends ModelFilter
{
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
    public function withCoincidence($params){
        $paramArray = explode('|', $params);
        if (count($paramArray)===3){ // params: attribute|keyword|ratio
            $attribute = $paramArray[0];
            $keyword = $paramArray[1];
            $ratio = $paramArray[2];
            if (is_numeric($ratio) && !!$attribute && !!$keyword ){
                return  $this->coincidence($attribute,$keyword,$ratio);
            }
            return $this->limit(0);
        }
        return $this->limit(0);
    }


}
