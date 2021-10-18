<?php 

namespace App\Filters;

use EloquentFilter\ModelFilter;

class QuestionFilter extends ModelFilter
{

    public function ids($ids){
        return $this->byIds($ids);
    }

    public function companyIds($ids){
        return $this->byCompanyByIds($ids);
    }

    public function nameQuestion($name){
        return $this->byNameQuestion($name);
    }

    /**
    * Related Models that have ModelFilters as well as the method on the ModelFilter
    * As [relationMethod => [input_key1, input_key2]].
    *
    * @var array
    */
    public $relations = [];
}
