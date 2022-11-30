<?php

namespace App\Models;

use EloquentFilter\Filterable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Operation
 *
 * @package Focus API
 *
 *
 * @OA\Schema(
 *     title="Operation model",
 *     description="Operation model",
 * )
 */

class Operation extends Model
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
     *     property="vehicle_id",
     *     type="integer",
     *     format="int64",
     *     description="Vehicle ID",
     *     title="Vehicle ID",
     * )
     *
     * @OA\Property(
     *     property="pending_task_id",
     *     type="integer",
     *     format="int64",
     *     description="Pending Task ID",
     *     title="Pending Task ID",
     * )
     *
     * @OA\Property(
     *     property="operation_type_id",
     *     type="integer",
     *     format="int64",
     *     description="Type of Operation ID",
     *     title="Type of Operation ID",
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
     */

    use HasFactory, Filterable;

    protected $fillable = [
        'vehicle_id',
        'pending_task_id',
        'operation_type_id',
        'description'
    ];

    public function vehicle(){
        return $this->belongsTo(Vehicle::class);
    }

    public function pendingTask(){
        return $this->belongsTo(PendingTask::class);
    }

    public function operationType(){
        return $this->belongsTo(OperationType::class);
    }

    public function scopeByIds($query, array $ids){
        return $query->whereIn('id', $ids);
    }

    public function scopeByVehicleIds($query, array $ids){
        return $query->whereIn('vehicle_id', $ids);
    }

    public function scopeByPendingTaskIds($query, array $ids){
        return $query->whereIn('pending_task_id', $ids);
    }

    public function scopeByOperationTypeIds($query, array $ids){
        return $query->whereIn('operation_type_id', $ids);
    }
}
