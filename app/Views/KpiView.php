<?php

namespace App\Views;

use Illuminate\Database\Eloquent\Model;
use EloquentFilter\Filterable;
use App\Models\TypeModelOrder;

class KpiView extends Model
{
    use Filterable;
    protected $table = 'view_kpis';

    public function typeModelOrder(){
        return $this->belongsTo(TypeModelOrder::class);
    }
}
