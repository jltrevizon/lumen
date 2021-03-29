<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Province;

class Campa extends Model
{
    public function users(){
        return $this->hasMany(User::class, 'user_id');
    }

    public function province(){
        return $this->belongsTo(Province::class, 'province_id');
    }
}
