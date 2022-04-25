<?php 

namespace App\Filters;

use EloquentFilter\ModelFilter;
use Illuminate\Database\Eloquent\Builder;

class DamageFilter extends ModelFilter
{

    public function ids($ids){
        return $this->byIds($ids);
    }

    public function campaIds($ids){
        return $this->whereIn('campa_id', $ids);
    }

    public function vehicleCampaIds($ids){
        return $this->whereHas('vehicle', function(Builder $builder) use($ids){
            return $builder->whereIn('campa_id', $ids);
        });
    }

    public function vehicleIds($ids){
        return $this->byVehicleIds($ids);
    }

    public function taskIds($ids){
        return $this->byTaskIds($ids);
    }

    public function groupTaskIds($ids){
        return $this->byGroupTaskIds($ids);
    }

    public function statusDamageIds($ids){
        return $this->byStatusDamageIds($ids);
    }

    public function plate($plate){
        return $this->byPlate($plate);
    }

    public function severityDamageIds($ids){
        return $this->bySeverityDamageIds($ids);
    }

    public function createdAtFrom($dateTime)
    {
        return $this->whereDate('created_at','>=', $dateTime);
    }

    public function createdAtTo($dateTime)
    {
        return $this->whereDate('created_at','<=', $dateTime); 
    }

    public function userIds($ids)
    {
        return $this->whereIn('user_id', $ids);
    }

    public function notNullDamageTypeId($value){
        return $this->whereNotNull('damage_type_id');
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
