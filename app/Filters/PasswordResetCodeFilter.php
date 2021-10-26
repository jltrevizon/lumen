<?php 

namespace App\Filters;

use EloquentFilter\ModelFilter;

class PasswordResetCodeFilter extends ModelFilter
{

    public function ids($ids){
        return $this->byIds($ids);
    }

    public function userIds($ids){
        return $this->byUserIds($ids);
    }

    public function active($active){
        return $this->byActive($active);
    }

    /**
    * Related Models that have ModelFilters as well as the method on the ModelFilter
    * As [relationMethod => [input_key1, input_key2]].
    *
    * @var array
    */
    public $relations = [];
}
