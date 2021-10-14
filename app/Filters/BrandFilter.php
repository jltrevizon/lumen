<?php 

namespace App\Filters;

use EloquentFilter\ModelFilter;

class BrandFilter extends ModelFilter
{
   public function ids($ids){
    return $this->byIds($ids);
   }

   public function name($name){
       return $this->byName($name);
   }
}
