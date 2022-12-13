<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Task;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class Type Task
 *
 * @package Focus API
 *
 *
 * @OA\Schema(
 *     title="Type Task model",
 *     description="Type Task model",
 * )
 */

class TypeTask extends Model
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

    const ACCESSORY = 1;
    const SPECIAL = 2;

    use HasFactory;

    protected $fillable = [
        'name'
    ];

    public function tasks(){
        return $this->hasMany(Task::class, 'type_task_id');
    }
}
