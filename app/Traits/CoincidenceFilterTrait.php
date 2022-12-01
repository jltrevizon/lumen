<?php

namespace App\Traits;

trait CoincidenceFilterTrait {
    public function withCoincidence($params){
        $paramArray = explode(';', $params);
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
