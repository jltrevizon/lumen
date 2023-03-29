<?php

namespace App\Models;

use EloquentFilter\Filterable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\SoftDeletes;


/**
 * Class Square
 *
 * @package Focus API
 *
 *
 * @OA\Schema(
 *     title="Square model",
 *     description="Square model",
 * )
 */

class Square extends Model
{

    /**
     * @OA\Schema(
     *      schema="SquarePaginate",
     *      allOf = {
     *          @OA\Schema(ref="#/components/schemas/Paginate"),
     *          @OA\Schema(
     *              @OA\Property(
     *                  property="data",
     *                  type="array",
     *                  @OA\Items(ref="#/components/schemas/SquareWithStreet"),
     *              ),
     *          ),
     *      },
     * )
     * @OA\Schema(
     *      schema="SquareWithStreet",
     *      allOf = {
     *          @OA\Schema(ref="#/components/schemas/Square"),
     *          @OA\Schema(
     *              @OA\Property(
     *                  property="street",
     *                  type="object",
     *                  ref="#/components/schemas/StreetWithZone"
     *              ),
     *          ),
     *      },
     * )
     * @OA\Schema(
     *      schema="SquareWithStreetAndVehicle",
     *      allOf = {
     *          @OA\Schema(ref="#/components/schemas/Square"),
     *          @OA\Schema(
     *              @OA\Property(
     *                  property="street",
     *                  type="object",
     *                  ref="#/components/schemas/StreetWithZone"
     *              ),
     *          ),
     *          @OA\Schema(
     *              @OA\Property(
     *                  property="vehicle",
     *                  type="object",
     *                  ref="#/components/schemas/Vehicle"
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
     *     property="street_id",
     *     type="integer",
     *     format="int64",
     *     description="Street ID",
     *     title="Street ID",
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
     *     property="user_id",
     *     type="integer",
     *     format="int64",
     *     description="User ID",
     *     title="User ID",
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
    use HasFactory, Filterable, SoftDeletes;

    protected $fillable = [
        'street_id',
        'vehicle_id',
        'user_id',
        'name'
    ];

    protected $dates = [
        'deleted_at'
    ];

    public function street(){
        return $this->belongsTo(Street::class);
    }

    public function vehicle(){
        return $this->belongsTo(Vehicle::class);
    }

    public function scopeByIds($query, array $ids){
        return $query->whereIn('id', $ids);
    }

    public function scopeByStreetIds($query, array $ids){
        return $query->whereIn('street_id', $ids);
    }

    public function scopeByVehicleIds($query, array $ids){
        return $query->whereIn('vehicle_id', $ids);
    }

    public function scopeByName($query, string $name){
        return $query->where('name','like',"%$name%");
    }

    public function scopeByCampaIds($query, array $ids){
        return $query->whereHas('street.zone.campa', function (Builder $builder) use ($ids){
            return $builder->whereIn('id', $ids);
        });
    }

}
