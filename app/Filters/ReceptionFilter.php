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

    public function finished($value){
        return $this->where('finished', $value);
    }

    public function createdAt($date){
        return $this->whereDate('created_at', $date);
    }

    public function brandIds($ids){
        return $this->whereHas('vehicle.vehicleModel', function($query) use($ids) {
            return $query->whereIn('brand_id', $ids);
        });
    }

    public function typeModelOrderIds($ids){
        return $this->whereHas('vehicle', function($query) use($ids) {
            return $query->whereIn('type_model_order_id', $ids);
        });
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
