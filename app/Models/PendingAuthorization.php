<?php

namespace App\Models;

use EloquentFilter\Filterable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Pending Authorization
 *
 * @package Focus API
 *
 *
 * @OA\Schema(
 *     title="Pending Authorization model",
 *     description="Pending Authorization model",
 * )
 */

class PendingAuthorization extends Model
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
     *     property="task_id",
     *     type="integer",
     *     format="int64",
     *     description="Task ID",
     *     title="Task ID",
     * )
     *
     * @OA\Property(
     *     property="damage_id",
     *     type="integer",
     *     format="int64",
     *     description="Damage ID",
     *     title="Damage ID",
     * )
     *
     * @OA\Property(
     *     property="state_authorization_id",
     *     type="integer",
     *     format="int64",
     *     description="State Authorization ID",
     *     title="State Authorization ID",
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

    use SoftDeletes, HasFactory, Filterable;

    protected $fillable = [
        'vehicle_id',
        'task_id',
        'damage_id',
        'state_authorization_id'
    ];

    protected $casts = [
        'vehicle_id' => 'integer',
        'task_id' => 'integer',
        'damage_id' => 'integer',
        'state_authorization_id' => 'integer'
    ];

    protected $dates = [
        'deleted_at'
    ];

    public function vehicle(){
        return $this->belongsTo(Vehicle::class);
    }

    public function task(){
        return $this->belongsTo(Task::class);
    }

    public function damage(){
        return $this->belongsTo(Damage::class);
    }

    public function stateAuthorization(){
        return $this->belongsTo(StateAuthorization::class);
    }

}
