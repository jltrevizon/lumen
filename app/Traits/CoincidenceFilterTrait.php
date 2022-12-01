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

    public function scopeCoincidence($query, $attribute, $keyword, $ratio){
        return $query->whereRaw("LEVENSHTEIN_RATIO({$attribute}, '{$keyword}') >= $ratio")
        ->orderByRaw("LEVENSHTEIN_RATIO({$attribute}, '{$keyword}') DESC")->take(1);
    }
}
