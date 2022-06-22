<?php

namespace App\Views;

use Illuminate\Database\Eloquent\Model;
use EloquentFilter\Filterable;
use App\Models\TypeModelOrder;
use App\Models\SubState;
use App\Models\State;

class KpiView extends Model
{
    use Filterable;
    protected $table = 'view_kpis';

    public function typeModelOrder(){
        return $this->belongsTo(TypeModelOrder::class);
    }

    public function state(){
        return $this->belongsTo(State::class);
    }

    public function subState(){
        return $this->belongsTo(SubState::class);
    }
}
