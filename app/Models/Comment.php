<?php

namespace App\Models;

use EloquentFilter\Filterable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    
    use HasFactory, Filterable;

    protected $fillable = [
        'damage_id',
        'user_id',
        'description'
    ];

    public function damage(){
        return $this->belongsTo(Damage::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function incidenceImages(){
        return $this->hasMany(IncidenceImage::class);
    }

    public function damageImages(){
        return $this->hasMany(DamageImage::class);
    }

    public function scopeByIds($query, array $ids){
        return $query->whereIn('id', $ids);
    }

    public function scopeByDamageIds($query, array $ids){
        return $query->whereIn('damage_id', $ids);
    }

    public function scopeByUserIds($query, array $ids){
        return $query->whereIn('user_id', $ids);
    }

}
