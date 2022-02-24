<?php

namespace App\Models;

use EloquentFilter\Filterable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Database\Eloquent\Model;

class DamageRole extends Model
{
    use HasFactory, Filterable;

    protected $fillable = [
        'damage_id',
        'role_id'
    ];
}
