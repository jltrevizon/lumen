<?php

namespace App\Models;

use EloquentFilter\Filterable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Damage
 *
 * @package Focus API
 *
 *
 * @OA\Schema(
 *     title="Damage model",
 *     description="Damage model",
 * )
 */

class Damage extends Model
{

    /**
     * @OA\Property(
     *     property="id",
     *     type="integer",
     *     format="int64",
     *     description="ID",
     *     title="ID",
     * )
     *
     * @OA\Property(
     *     property="campa_id",
     *     type="integer",
     *     format="int64",
     *     description="Campa ID",
     *     title="Campa ID",
     * )
     *
     * @OA\Property(
     *     property="user_id",
     *     type="integer",
     *     format="int64",
     *     description="User ID",
     *     title="User ID",
     * )
     *
     * @OA\Property(
     *     property="vehicle_id",
     *     type="integer",
     *     format="int64",
     *     description="Vehicle ID",
     *     title="Vehicle ID",
     * )
     *
     * @OA\Property(
     *     property="group_task_id",
     *     type="integer",
     *     format="int64",
     *     description="Group Task ID",
     *     title="Group Task ID",
     * )
     *
     * @OA\Property(
     *     property="damage_type_id",
     *     type="integer",
     *     format="int64",
     *     description="Type of Damage ID",
     *     title="Type of Damage ID",
     * )
     *
     * @OA\Property(
     *     property="task_id",
     *     type="integer",
     *     format="int64",
     *     description="Task ID",
     *     title="Task ID",
     * )
     *
     * @OA\Property(
     *     property="severity_damage_id",
     *     type="integer",
     *     format="int64",
     *     description="Severity Damage ID",
     *     title="Severity Damage ID",
     * )
     *
     * @OA\Property(
     *     property="status_damage_id",
     *     type="integer",
     *     format="int64",
     *     description="Status Damage ID",
     *     title="Status Damage ID",
     * )
     *
     * @OA\Property(
     *     property="description",
     *     type="string",
     *     description="Description",
     *     title="Description",
     * )
     *
     * @OA\Property(
     *     property="approved",
     *     type="boolean",
     *     description="Approved",
     *     title="Approved",
     * )
     *
     * @OA\Property(
     *     property="internal",
     *     type="boolean",
     *     description="Internal",
     *     title="Internal",
     * )
     *
     * @OA\Property(
     *     property="datetime_close",
     *     type="string",
     *     format="date-time",
     *     description="Datetinme close",
     *     title="Datetime close",
     * )
     *
     * @OA\Property(
     *     property="created_at",
     *     type="string",
     *     format="date-time",
     *     description="When was created",
     *     title="Created at",
     * )
     *
     * @OA\Property(
     *     property="updated_at",
     *     type="string",
     *     format="date-time",
     *     description="When was last updated",
     *     title="Updated at",
     * )
     *
     * @OA\Property(
     *     property="deleted_at",
     *     type="string",
     *     format="date-time",
     *     description="When was deleted",
     *     title="Deleted at",
     * )
     */

    use HasFactory, Filterable, SoftDeletes;

    protected $fillable = [
        'campa_id',
        'user_id',
        'vehicle_id',
        'group_task_id',
        'damage_type_id',
        'task_id',
        'severity_damage_id',
        'status_damage_id',
        'description',
        'approved',
        'internal',
        'datetime_close',
    ];

    public function campa(){
        return $this->belongsTo(Campa::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function vehicle(){
        return $this->belongsTo(Vehicle::class);
    }

    public function groupTask(){
        return $this->belongsTo(GroupTask::class);
    }

    public function damageType(){
        return $this->belongsTo(DamageType::class);
    }

    public function task(){
        return $this->belongsTo(Task::class);
    }

    public function comments(){
        return $this->hasMany(Comment::class);
    }

    public function roles(){
        return $this->belongsToMany(Role::class);
    }

    public function tasks(){
        return $this->belongsToMany(Task::class);
    }

    public function statusDamage(){
        return $this->belongsTo(StatusDamage::class);
    }

    public function severityDamage(){
        return $this->belongsTo(SeverityDamage::class);
    }

    public function damageImages(){
        return $this->hasMany(DamageImage::class);
    }

    public function pendingAuthorizations(){
        return $this->hasMany(PendingAuthorization::class);
    }

    public function scopeByIds($query, array $ids){
        return $query->whereIn('id', $ids);
    }

    public function scopeByVehicleIds($query, array $ids){
        return $query->whereIn('vehicle_id', $ids);
    }

    public function scopeByTaskIds($query, array $ids){
        return $query->whereHas('tasks', function($builder) use($ids) {
            return $builder->whereIn('task_id', $ids);
        });
    }

    public function scopeByGroupTaskIds($query, array $ids){
        return $query->whereIn('group_task_id', $ids);
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
