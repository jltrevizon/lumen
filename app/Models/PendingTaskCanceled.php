<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Pending Task Canceled
 *
 * @package Focus API
 *
 *
 * @OA\Schema(
 *     title="Pending Task Canceled model",
 *     description="Pending Task Canceled model",
 * )
 */

class PendingTaskCanceled extends Model
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

    use HasFactory;

    protected $fillable = [
        'pending_task_id',
        'description'
    ];

    public function pendingTask(){
        return $this->belongsTo(PendingTask::class);
    }
}
