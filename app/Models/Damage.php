<?php

namespace App\Models;

use EloquentFilter\Filterable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Damage extends Model
{
    
    use HasFactory, Filterable;

    protected $fillable = [
        'user_id',
        'vehicle_id',
        'task_id',
        'severity_damage_id',
        'status_damage_id',
        'description'
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function vehicle(){
        return $this->belongsTo(Vehicle::class);
    }

    public function task(){
        return $this->belongsTo(Task::class);
    }

    public function statusDamage(){
        return $this->belongsTo(StatusDamage::class);
    }

    public function severityDamage(){
        return $this->belongsTo(SeverityDamage::class);
    }

    public function scopeByIds($query, array $ids){
        return $query->whereIn('id', $ids);
    }

    public function scopeByVehicleIds($query, array $ids){
        return $query->whereIn('vehicle_id', $ids);
    }

    public function scopeByTaskIds($query, array $ids){
        return $query->whereIn('task_id', $ids);
    }

    public function scopeByStatusDamageIds($query, array $ids){
        return $query->whereIn('status_damage_id', $ids);
    }
    
    public function scopeByPlate($query, string $plate){
        return $query->whereHas('vehicle', function (Builder $builder) use($plate){
            return $builder->where('plate', 'like',"%$plate%");
        });
    }

    public function scopeBySeverityDamageIds($query, array $ids){
        return $query->whereIn('severity_damage_id', $ids);
    }
}
