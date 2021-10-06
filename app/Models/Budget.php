<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Budget extends Model
{

    use HasFactory;

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

}
