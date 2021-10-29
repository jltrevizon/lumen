<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Damage extends Model
{
    
    use HasFactory;

    protected $fillable = [
        'vehicle_id',
        'task_id',
        'status_damage_id',
        'description'
    ];

    public function vehicle(){
        return $this->belongsTo(Vehicle::class);
    }

    public function task(){
        return $this->belongsTo(Task::class);
    }

    public function statusDamage(){
        return $this->belongsTo(StatusDamage::class);
    }

}
