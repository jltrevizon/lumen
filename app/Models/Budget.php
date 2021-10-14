<?php

namespace App\Models;

use EloquentFilter\Filterable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Budget extends Model
{

    use HasFactory, Filterable;

    protected $fillable = [
        'vehicle_id',
        'order_id',
        'sub_total',
        'tax',
        'total'
    ];

    public function budgetLines(){
        return $this->hasMany(BudgetLine::class);
    }

    public function vehicle(){
        return $this->belongsTo(Vehicle::class);
    }

    public function scopeByIds($query, $ids){
        return $query->whereIn('id', $ids);
    }

    public function scopeByVehicleIds($query, $ids){
        return $query->whereIn('vehicle_id', $ids);
    }

    public function scopeByOrderIds($query, $ids){
        return $query->whereIn('order_id', $ids);
    }

}
