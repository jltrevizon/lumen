<?php

namespace App\Filters;

use EloquentFilter\ModelFilter;
use Illuminate\Database\Eloquent\Builder;

class VehicleExitFilter extends ModelFilter
{

    public function ids($ids){
        return $this->whereIn('id', $ids);
    }

    public function vehicleIds($ids){
        return $this->whereIn('vehicle_id', $ids);
    }

    public function campaIds($ids){
        return $this->whereIn('campa_id', $ids);
    }

    public function pendingTaskIds($ids){
        return $this->whereIn('pending_task_id', $ids);
    }

    public function createdAt($date){
        return $this->whereDate('created_at', $date);
    }

    public function createdAtFrom($dateTime)
    {
        return $this->where('created_at','>=', $dateTime);
    }

    public function createdAtTo($dateTime)
    {
        return $this->where('created_at','<=', $dateTime);
    }

    public function vehiclePlate($plate){
        return $this->whereHas('vehicle', function(Builder $builder) use($plate){
            return $builder->where('plate','like',"%$plate%");
        });
    }

    public function vehicleBrandIds($ids){
        return $this->whereHas('vehicle.vehicleModel', function(Builder $builder) use($ids){
            return $builder->whereIn('brand_id', $ids);
        });
    }

    public function vehicleTypeModelOrderIds($ids){
        return $this->whereHas('vehicle', function(Builder $builder) use($ids){
            return $builder->whereIn('type_model_order_id', $ids);
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
