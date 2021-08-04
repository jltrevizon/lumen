<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Vehicle;
use App\Models\StateRequest;
use App\Models\TypeRequest;
use App\Models\Reservation;
use App\Models\Customer;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Request extends Model
{

    use HasFactory;

    protected $fillable = [
        'customer_id',
        'vehicle_id',
        'state_request_id',
        'type_request_id',
        'datetime_request',
        'datetime_decline'
    ];

    public function vehicle(){
        return $this->belongsTo(Vehicle::class, 'vehicle_id');
    }

    public function state_request(){
        return $this->belongsTo(StateRequest::class, 'state_request_id');
    }

    public function type_request(){
        return $this->belongsTo(TypeRequest::class, 'type_request_id');
    }

    public function reservation(){
        return $this->hasOne(Reservation::class, 'request_id');
    }

    public function customer(){
        return $this->belongsTo(Customer::class, 'customer_id');
    }

    public function scopeByVehicleInCampa($query, int $campaId){
        return $query->whereHas('vehicle', function(Builder $builder) use($campaId) {
            return $builder->where('campa_id', $campaId);
        });
    }

    public function scopeByVehicleInCampas($query, array $campaIds){
        return $query->whereHas('vehicle', function(Builder $builder) use($campaIds) {
            return $builder->whereIn('campa_id', $campaIds);
        });
    }
}
