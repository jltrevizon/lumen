<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Task Reservation
 *
 * @package Focus API
 *
 *
 * @OA\Schema(
 *     title="Task Reservation model",
 *     description="Task Reservation model",
 * )
 */

class TaskReservation extends Model
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
     *     property="request_id",
     *     type="integer",
     *     format="int64",
     *     description="Request ID",
     *     title="Request ID",
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
     *     property="vehicle_id",
     *     type="integer",
     *     format="int64",
     *     description="Vehicle ID",
     *     title="Vehicle ID",
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
     *     property="order",
     *     type="integer",
     *     format="int32",
     *     description="Order",
     *     title="Order",
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
}
