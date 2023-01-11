<?php

namespace App\Models;

use EloquentFilter\Filterable;
use Illuminate\Database\Eloquent\Model;

/**
 * Class State Change
 *
 * @package Focus API
 *
 *
 * @OA\Schema(
 *     title="State Change model",
 *     description="State Change model",
 * )
 */

class StateChange extends Model
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
     *     property="pending_task_id",
     *     type="integer",
     *     format="int64",
     *     description="Pending Task ID",
     *     title="Pending Task ID",
     * )
     *
     * @OA\Property(
     *     property="sub_state_id",
     *     type="integer",
     *     format="int64",
     *     description="Sub State ID",
     *     title="Sub State ID",
     * )
     *
     * @OA\Property(
     *     property="total_time",
     *     type="integer",
     *     format="int32",
     *     description="Total Time",
     *     title="Total Time",
     * )
     *
     * @OA\Property(
     *     property="datetime_finish_sub_state",
     *     type="string",
     *     format="date-time",
     *     description="Datetime finish Sub state",
     *     title="Datetime finish Sub state",
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

    use Filterable;

    protected $fillable = [
        'campa_id',
        'vehicle_id',
        'pending_task_id',
        'group_task_id',
        'sub_state_id',
        'total_time',
        'datetime_finish_sub_state'
    ];

    public function campa(){
        return $this->belongsTo(Campa::class);
    }

    public function vehicle(){
        return $this->belongsTo(Vehicle::class);
    }

    public function groupTask(){
        return $this->belongsTo(GroupTask::class);
    }

    public function subState(){
        return $this->belongsTo(SubState::class);
    }

    public function pendingTask(){
        return $this->belongsTo(PendingTask::class);
    }

}
