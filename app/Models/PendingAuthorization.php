<?php

namespace App\Models;

use EloquentFilter\Filterable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PendingAuthorization extends Model
{
    
    use SoftDeletes, HasFactory, Filterable;

    protected $fillable = [
        'vehicle_id',
        'task_id',
        'damage_id',
        'state_authorization_id'
    ];

    protected $casts = [
        'vehicle_id' => 'integer',
        'task_id' => 'integer',
        'damage_id' => 'integer',
        'state_authorization_id' => 'integer'
    ];

    protected $dates = [
        'deleted_at'
    ];

    public function vehicle(){
        return $this->belongsTo(Vehicle::class);
    }

    public function task(){
        return $this->belongsTo(Task::class);
    }

    public function damage(){
        return $this->belongsTo(Damage::class);
    }

    public function stateAuthorization(){
        return $this->belongsTo(StateAuthorization::class);
    }

}
