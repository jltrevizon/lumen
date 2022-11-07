<?php

namespace App\Models;

use EloquentFilter\Filterable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CampaTypeModelOrder extends Model
{

    use HasFactory, Filterable;

    protected $fillable = [
        'campa_id',
        'type_model_order_id'
    ];

    public function campa(){
        return $this->belongsTo(Campa::class, 'campa_id');
    }

    public function typeModelOrder(){
        return $this->belongsTo(TypeModelOrder::class, 'type_model_order_id');
    }
}
