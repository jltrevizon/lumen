<?php

namespace App\Models;

use EloquentFilter\Filterable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DeliveryVehicle extends Model
{

    use HasFactory, Filterable, SoftDeletes;

    protected $fillable = [
        'vehicle_id',
        'campa_id',
        'delivery_note_id',
        'data_delivery'
    ];

    protected $casts = [
    	'vehicle_id' => 'integer',
        'campa_id' => 'integer',
        'delivery_note_id' => 'integer',
    	'data_delivery' => 'json'
    ];

    protected $dates = [
        'deleted_at'
    ];

    public function scopeByIds($query, $ids){
        return $query->whereIn('id', $ids);
    }

    public function vehicle(){
        return $this->belongsTo(Vehicle::class);
    }

    public function campa(){
        return $this->belongsTo(Campa::class);
    }

    public function deliveryNote(){
        return $this->belongsTo(DeliveryNote::class);
    }
}
