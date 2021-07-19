<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\State;
use App\Models\Task;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SubState extends Model
{

    use HasFactory;

    protected $fillable = [
        'state_id',
        'name'
    ];

    public function state(){
        return $this->belongsTo(State::class, 'state_id');
    }

    public function tasks(){
        return $this->hasMany(Task::class, 'sub_state_id');
    }

    public function type_users_app(){
        return $this->belongsToMany(TypeUserApp::class);
    }
}
