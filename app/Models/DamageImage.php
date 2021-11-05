<?php

namespace App\Models;

use EloquentFilter\Filterable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DamageImage extends Model
{
    
    use HasFactory, Filterable;

    protected $fillable = [
        'damage_id',
        'url',
    ];

    public function damage(){
        return $this->belongsTo(Damage::class);
    }

    public function scopeByIds($query, array $ids){
        return $query->whereIn('id', $ids);
    }

    public function scopeByDamageIds($query, array $ids){
        return $query->whereIn('damage_id', $ids);
    }

}
