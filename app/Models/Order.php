<?php

namespace App\Models;

use EloquentFilter\Filterable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{

    use Filterable, HasFactory;

    protected $fillable = [
        'vehicle_id',
        'workshop_id',
        'state_id',
        'type_model_order_id',
        'id_gsp'
    ];

    public function vehicle(){
        return $this->belongsTo(Vehicle::class);
    }

    public function workshop(){
        return $this->belongsTo(Workshop::class);
    }

    public function state(){
        return $this->belongsTo(State::class);
    }

    public function typeModelOrder(){
        return $this->belongsTo(TypeModelOrder::class);
    }

    public function scopeByStateIds($query, array $ids){
        return $query->whereIn('state_id', $ids);
    }

    public function scopeByWorkshopId($query, int $id){
        return $query->where('workshop_id', $id);
    }

    public function scopeByIds($query, array $ids){
        return $query->whereIn('id', $ids);
    }

    public function scopeByVehiclePlate($query, string $plate){
        return $query->whereHas('vehicle', function(Builder $builder) use($plate){
            return $builder->where('plate','like',"%$plate%");
        });
    }
}
