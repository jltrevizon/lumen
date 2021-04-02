<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Province;

class Region extends Model
{
    public function provinces(){
        return $this->hasMany(Province::class, 'region_id');
    }
}
