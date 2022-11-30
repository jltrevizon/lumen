<?php

namespace App\Models;

use EloquentFilter\Filterable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Budget pending task
 *
 * @package Focus API
 *
 *
 * @OA\Schema(
 *     title="Budget pending task model",
 *     description="Budget pending task model",
 * )
 */

class BudgetPendingTask extends Model
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
     *     property="role_id",
     *     type="integer",
     *     format="int64",
     *     description="Role ID",
     *     title="Role ID",
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
     *     property="state_budget_pending_task_id",
     *     type="integer",
     *     format="int64",
     *     description="State of Budget Pending Task ID",
     *     title="State of Budget Pending Task ID",
     * )
     *
     * @OA\Property(
     *     property="code_authorization",
     *     type="integer",
     *     format="int32",
     *     description="Code of Authorization",
     *     title="Code of Authorization",
     * )
     *
     * @OA\Property(
     *     property="observations",
     *     type="string",
     *     description="Observations",
     *     title="Observations",
     * )
     *
     * @OA\Property(
     *     property="url",
     *     type="string",
     *     format="url",
     *     description="URL",
     *     title="URL",
     * )
     *
     * @OA\Property(
     *     property="approved_by",
     *     type="integer",
     *     format="int64",
     *     description="Approved by",
     *     title="Approved by",
     * )
     *
     * @OA\Property(
     *     property="declined_by",
     *     type="integer",
     *     format="int64",
     *     description="Declined by",
     *     title="Declined by",
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
     *     property="comment",
     *     type="string",
     *     description="Comment",
     *     title="Comment",
     * )
     */
    use Filterable, HasFactory;

    protected $fillable = [
        'campa_id',
        'role_id',
        'pending_task_id',
        'state_budget_pending_task_id',
        'code_authorization',
        'observations',
        'approved_by',
        'declined_by',
        'url',
        'comment'
    ];

    public function campa(){
        return $this->belongsTo(Campa::class);
    }

    public function role(){
        return $this->belongsTo(Role::class);
    }

    public function pendingTask(){
        return $this->belongsTo(PendingTask::class);
    }

    public function stateBudgetPendingTask(){
        return $this->belongsTo(StateBudgetPendingTask::class);
    }

    public function scopeByPendingTaskIds($query, $ids){
        return $query->whereIn('pending_task_id', $ids);
    }

    public function scopeByTaskIds($query, $ids){
        return $query->whereHas('pendingTask', function($q) use($ids) {
            return $q->whereIn('task_id', $ids);
        });
    }

    public function scopeByStateBudgetPendingTaskIds($query, $ids){
        return $query->whereIn('state_budget_pending_task_id', $ids);
    }

    public function scopeByPlate($query, $plate){
        return $query->whereHas('pendingTask.vehicle', function(Builder $builder) use($plate) {
            return $builder->where('plate','like',"%$plate%");
        });
    }
}
