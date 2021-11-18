<?php 

namespace App\Filters;

use EloquentFilter\ModelFilter;

class ReceptionFilter extends ModelFilter
{

    public function campaIds($ids){
        return $this->whereIn('campa_id', $ids);
    }

    public function vehicleIds($ids){
        return $this->whereIn('vehicle_id', $ids);
    }

    /**
    * Related Models that have ModelFilters as well as the method on the ModelFilter
    * As [relationMethod => [input_key1, input_key2]].
    *
    * @var array
    */
    public $relations = [];
}
