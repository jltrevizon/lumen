<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SeverityDamage extends Model
{

    use HasFactory;
    
    protected $fillable = [
        'description'
    ];

    public function damages(){
        return $this->hasMany(Damage::class);
    }

}
