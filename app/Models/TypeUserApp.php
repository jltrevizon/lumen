<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TypeUserApp extends Model
{
    use HasFactory;

    public function subStates(){
        return $this->belongsToMany(SubState::class);
    }

    public function users(){
        return $this->hasMany(User::class);
    }
}
