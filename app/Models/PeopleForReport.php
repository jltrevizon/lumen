<?php

namespace App\Models;

use EloquentFilter\Filterable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PeopleForReport extends Model
{

    use HasFactory, Filterable;

    protected $fillable = [
        'user_id',
        'type_report_id'
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function typeReport(){
        return $this->belongsTo(TypeReport::class);
    }

    public function scopeByIds($query, array $ids){
        return $query->whereIn('id', $ids);
    }

    public function scopeByUserIds($query, array $ids){
        return $query->whereIn('user_id', $ids);
    }

    public function scopeByTypeReportIds($query, array $ids){
        return $query->whereIn('type_report_id', $ids);
    }

}
