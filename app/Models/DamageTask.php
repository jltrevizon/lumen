<?php

namespace App\Models;

use EloquentFilter\Filterable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DamageTask extends Model
{
    use HasFactory, Filterable;

    protected $table = 'damage_task'; 

    protected $fillable = [
        'damage_id',
        'task_id'
    ];

    public function damage(){
        return $this->belongsTo(Damage::class);
    }

    public function task(){
        return $this->belongsTo(Task::class);
    }
}
