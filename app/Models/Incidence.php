<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\PendingTask;
use EloquentFilter\Filterable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Incidence extends Model
{

    use HasFactory, Filterable;

    protected $fillable = [
        'vehicle_id',
        'description',
        'read',
        'resolved'
    ];

    public function pending_tasks(){
        return $this->belongsToMany(PendingTask::class);
    }

    public function vehicle(){
        return $this->belongsTo(Vehicle::class);
    }

    public function comments(){
        return $this->hasMany(Comment::class);
    }

    public function incidenceImages(){
        return $this->hasMany(IncidenceImage::class);
    }

    public function scopeByIds($query, array $ids){
        return $query->whereIn('id', $ids);
    }

    public function scopeByResolved($query, bool $resolved){
        return $query->where('resolved', $resolved);
    }

    public function scopeByVehicleIds($query, array $ids){
        return $query->whereIn('id', $ids);
    }

    public function scopeByRead($query, bool $read){
        return $query->where('read', $read);
    }
}
