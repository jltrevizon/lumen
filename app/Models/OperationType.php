<?php

namespace App\Models;

use EloquentFilter\Filterable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OperationType extends Model
{

    use HasFactory, Filterable;

    const REPAIR = 1;
    const REPLACE = 2;

    protected $fillable = [
        'name'
    ];

    public function operations(){
        return $this->hasMany(Operation::class);
    }

    public function scopeByIds($query, array $ids){
        return $query->whereIn('id', $ids);
    }

}
