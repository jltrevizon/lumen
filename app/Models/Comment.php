<?php

namespace App\Models;

use EloquentFilter\Filterable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    
    use HasFactory, Filterable;

    protected $fillable = [
        'incidence_id',
        'user_id',
        'description'
    ];

    public function incidence(){
        return $this->belongsTo(Incidence::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function scopeByIds($query, array $ids){
        return $query->whereIn('id', $ids);
    }

    public function scopeByIncidenceIds($query, array $ids){
        return $query->whereIn('incidence_id', $ids);
    }

    public function scopeByUserIds($query, array $ids){
        return $query->whereIn('user_id', $ids);
    }

}
