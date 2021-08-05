<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\State;
use App\Models\Task;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SubState extends Model
{

    use HasFactory;

    const CAMPA = 1;
    const PENDIENTE_LAVADO = 2;
    const MECANICA = 3;
    const CHAPA = 4;
    const TRANSFORMACION = 5;
    const ITV = 6;
    const LIMPIEZA = 7;
    const SOLICITUD_DEFLEET = 8;
    const SIN_DOCUMENTACION = 9;
    const ALQUILADO = 10;
    const CHECK = 11;
    const NOT_AVAILABLE = 12;
    const PENDING_TEST_DINAMIC = 13;
    const PENDING_INITIAL_CHECK = 14;
    const PENDING_BUDGET = 15;
    const PENDING_AUTHORIZATION = 16;
    const IN_REPAIR = 17;
    const PENDING_CERTIFICATED = 18;
    const PENDING_FINAL_CHECK = 19;

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
