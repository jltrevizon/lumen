<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Class State Budget Pending Task
 *
 * @package Focus API
 *
 *
 * @OA\Schema(
 *     title="State Budget Pending Task model",
 *     description="State Budget Pending Task model",
 * )
 */

class StateBudgetPendingTask extends Model
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
    const APPROVED = 2;
    const DECLINE = 3;

    public function budgetPendingTasks(){
        return $this->hasMany(BudgetPendingTask::class);
    }
}
