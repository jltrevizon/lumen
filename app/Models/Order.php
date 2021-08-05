<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{

    protected $fillable = [
        'vehicle_id',
        'workshop_id',
        'state_id',
        'type_model_order_id',
        'id_gsp'
    ];

}
