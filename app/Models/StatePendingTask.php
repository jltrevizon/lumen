<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\PendingTask;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class State Pending Task
 *
 * @package Focus API
 *
 *
 * @OA\Schema(
 *     title="State Pending Task model",
 *     description="State Pending Task model",
 * )
 */

class StatePendingTask extends Model
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
     *     property="name",
     *     type="string",
     *     description="Name",
     *     title="Name",
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

    use HasFactory;

    const PENDING = 1;
    const IN_PROGRESS = 2;
    const FINISHED = 3;
    const CANCELED = 4;

    protected $fillable = [
        'name'
    ];

    public function pendingTasks(){
        return $this->hasMany(PendingTask::class, 'state_pending_task_id');
    }
}
