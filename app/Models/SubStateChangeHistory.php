<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Sub State Change History
 *
 * @package Focus API
 *
 *
 * @OA\Schema(
 *     title="Sub State Change History model",
 *     description="Sub State Change History model",
 * )
 */

class SubStateChangeHistory extends Model
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
     *     property="sub_state_id",
     *     type="integer",
     *     format="int64",
     *     description="Sub State ID",
     *     title="Sub State ID",
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
        'vehicle_id',
        'sub_state_id'
    ];

    public function vehicle(){
        return $this->belongsTo(Vehicle::class);
    }

    public function subState(){
        return $this->belongsTo(SubState::class);
    }

}
