<?php

namespace App\Models;

use EloquentFilter\Filterable;
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
        return $this->belongsTo(workshop::class);
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
}
