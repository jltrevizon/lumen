<?php

namespace App\Models;

use EloquentFilter\Filterable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IncidenceImage extends Model
{
    
    use HasFactory, Filterable;

    protected $fillable = [
        'incidence_id',
        'comment_id',
        'url'
    ];

    public function incidence(){
        return $this->belongsTo(Incidence::class);
    }

    public function comment(){
        return $this->belongsTo(Comment::class);
    }

    public function scopeByIds($query, array $ids){
        return $query->whereIn('id', $ids);
    }

    public function scopeByIncidenceIds($query, array $ids){
        return $query->whereIn('incidence_id', $ids);
    }

    public function scopeByCommentIds($query, array $ids){
        return $query->whereIn('comment_id', $ids);
    }

}
