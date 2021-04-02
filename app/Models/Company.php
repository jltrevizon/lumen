<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Campa;

class Company extends Model
{
    public function campas(){
        return $this->hasMany(Campa::class, 'company_id');
    }
}
