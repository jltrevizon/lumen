<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Estimated Date
 *
 * @package Focus API
 *
 *
 * @OA\Schema(
 *     title="Estimated Date model",
 *     description="Estimated Date model",
 * )
 */

class EstimatedDate extends Model
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
     *     property="pending_task_id",
     *     type="integer",
     *     format="int64",
     *     description="Pending Task ID",
     *     title="Pending Task ID",
     * )
     *
     * @OA\Property(
     *     property="reason",
     *     type="string",
     *     description="Reason",
     *     title="Reason",
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

    protected $fillable = [
        'pending_task_id',
        'estimated_date',
        'reason'
    ];

    public function pendingTask()
    {
        return $this->belongsTo(PendingTask::class);
    }

}
