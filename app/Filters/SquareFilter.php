<?php 

namespace App\Filters;

use EloquentFilter\ModelFilter;
use Illuminate\Database\Eloquent\Builder;

class SquareFilter extends ModelFilter
{

    public function ids($ids){
        return $this->byIds($ids);
    }

    public function streetIds($ids){
        return $this->byStreetIds($ids);
    }

    public function zoneIds($ids){
        return $this->whereHas('street', function(Builder $builder) use($ids){
            return $builder->whereIn('zone_id', $ids);
        });
    }

    public function vehicleIds($ids){
        return $this->byVehicleIds($ids);
    }

    public function name($ids){
        return $this->byName($ids);
    }

    public function campaIds($ids){
        return $this->byCampaIds($ids);
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
