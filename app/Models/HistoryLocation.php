<?php

namespace App\Models;

use EloquentFilter\Filterable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HistoryLocation extends Model
{
    
    use HasFactory, Filterable;

    protected $fillable = [
        'vehicle_id',
        'square_id'
    ];

    protected $dates = [
        'deleted_at'
    ];

    public function vehicle(){
        return $this->belongsTo(Vehicle::class);
    }

    public function square(){
        return $this->belongsTo(Square::class);
    }

}
