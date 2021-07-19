<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TypeUserApp extends Model
{

    public function sub_states(){
        return $this->belongsToMany(SubState::class);
    }

    public function users(){
        return $this->hasMany(User::class);
    }
}
