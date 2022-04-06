<?php 

namespace App\Filters;

use EloquentFilter\ModelFilter;

class CustomerFilter extends ModelFilter
{

    public function ids($ids){
        return $this->byIds($ids);
    }

    public function companyIds($ids){
        return $this->byCompanies($ids);
    }

    public function provinceIds($ids){
        return $this->byProvince($ids);
    }

    public function name($name){
        return $this->byName($name);
    }

    public function cif($cif){
        return $this->byCif($cif);
    }

    public function phone($phone){
        return $this->byPhone($phone);
    }

    public function address($address){
        return $this->byAddress($address);
    }

    public function orderDesc($field){
        return $this->orderByDesc($field);
    }

    public function order($field){
        return $this->orderBy($field);
    }


    /**
    * Related Models that have ModelFilters as well as the method on the ModelFilter
    * As [relationMethod => [input_key1, input_key2]].
    *
    * @var array
    */
    public $relations = [];
}
