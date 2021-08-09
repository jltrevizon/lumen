<?php

namespace App\Filters;

use EloquentFilter\ModelFilter;

class OrderFilter extends ModelFilter
{
    public function states($ids){
        return $this->byStateIds($ids);
    }
}
