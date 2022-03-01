<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DamageType extends Model
{
    
    use HasFactory;

    protected $fillable = [
        'description'
    ];

    protected $casts = [
        'description' => 'string'
    ];

    public function damages(){
        return $this->hasMany(Damage::class);
    }

}
