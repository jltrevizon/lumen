<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StatusDamage extends Model
{

    use HasFactory;

    const OPEN = 1;
    const CLOSED = 2;
    const DECLINED = 3;
    
    protected $fillable = [
        'description'
    ];

    public function damages(){
        return $this->hasMany(Damage::class);
    }

}
