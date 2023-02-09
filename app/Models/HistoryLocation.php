<?php

namespace App\Models;

use EloquentFilter\Filterable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Class History Location
 *
 * @package Focus API
 *
 *
 * @OA\Schema(
 *     title="History Location model",
 *     description="History Location model",
 * )
 */

class HistoryLocation extends Model
{

    /**
     * @OA\Schema(
     *      schema="HistoryLocationPaginate",
     *      allOf = {
     *          @OA\Schema(ref="#/components/schemas/Paginate"),
     *          @OA\Schema(
     *              @OA\Property(
     *                  property="data",
     *                  type="array",
     *                  @OA\Items(ref="#/components/schemas/HistoryLocationWithVehicleAndUser"),
     *              ),
     *          ),
     *      },
     * )
     * @OA\Schema(
     *      schema="HistoryLocationWithVehicleAndUser",
     *      allOf = {
     *          @OA\Schema(ref="#/components/schemas/HistoryLocation"),
     *          @OA\Schema(
     *              @OA\Property(
     *                  property="user",
     *                  type="object",
     *                  ref="#/components/schemas/User",
     *              ),
     *              @OA\Property(
     *                  property="vehicle",
     *                  type="object",
     *                  ref="#/components/schemas/VehicleWithTypeModelOrderAndVehicleModel",
     *              ),
     *          ),
     *      },
     * )
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
     *     property="square_id",
     *     type="integer",
     *     format="int64",
     *     description="Square ID",
     *     title="Square ID",
     * )
     *
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
     *
     * @OA\Property(
     *     property="user_id",
     *     type="integer",
     *     format="int64",
     *     description="User ID",
     *     title="User ID",
     * )
     */

    use HasFactory, Filterable;

    protected $fillable = [
        'vehicle_id',
        'square_id',
        'user_id'
    ];

    protected $dates = [
        'deleted_at'
    ];

    public function vehicle(){
        return $this->belongsTo(Vehicle::class);
    }

    public function square(){
        return $this->belongsTo(Square::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }

}
