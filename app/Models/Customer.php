<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Province;

class Customer extends Model
{
    public function province(){
        return $this->belongsTo(Province::class, 'province_id');
    }
}
