<?php 

namespace App\Filters;

use EloquentFilter\ModelFilter;

class GroupTaskFilter extends ModelFilter
{

    public function ids($ids){
        return $this->byIds($ids);
    }

    public function vehicleIds($ids){
        return $this->byVehicleIds($ids);
    }

    public function approved($approved){
        return $this->byApproved($approved);
    }

    public function orderDesc($field){
        return $this->orderByDesc($field);
    }

    public function order($field){
        return $this->orderBy($field);
    }

    public function typeModelOrderIds($ids){
        return $this->whereHas('vehicle', function($query) use($ids) {
            return $query->whereIn('type_model_order_id', $ids);
        });
    }

    /**
    * Related Models that have ModelFilters as well as the method on the ModelFilter
    * As [relationMethod => [input_key1, input_key2]].
    *
    * @var array
    */
    public $relations = [];
}
