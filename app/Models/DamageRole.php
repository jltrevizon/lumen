<?php

namespace App\Models;

use EloquentFilter\Filterable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Database\Eloquent\Model;

class DamageRole extends Model
{
    use HasFactory, Filterable;

    protected $table = 'damage_role';

    protected $fillable = [
        'damage_id',
        'role_id'
    ];

    public function damage(){
        return $this->belongsTo(Damage::class);
    }

    public function role(){
        return $this->belongsTo(Role::class);
    }
}
