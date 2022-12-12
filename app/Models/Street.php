<?php

namespace App\Models;

use EloquentFilter\Filterable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Street
 *
 * @package Focus API
 *
 *
 * @OA\Schema(
 *     title="Street model",
 *     description="Street model",
 * )
 */

class Street extends Model
{

    /**
     * @OA\Schema(
     *      schema="StreetWithZone",
     *      allOf = {
     *          @OA\Schema(ref="#/components/schemas/Street"),
     *          @OA\Schema(
     *              @OA\Property(
     *                  property="zone",
     *                  type="object",
     *                  ref="#/components/schemas/Zone"
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
     *     property="zone_id",
     *     type="integer",
     *     format="int64",
     *     description="Zone ID",
     *     title="Zone ID",
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

    use HasFactory, Filterable;

    protected $fillable = [
        'zone_id',
        'name'
    ];

    public function zone(){
        return $this->belongsTo(Zone::class);
    }

    public function scopeByIds($query, array $ids){
        return $query->whereIn('id', $ids);
    }

    public function scopeByZoneIds($query, array $ids){
        return $query->whereIn('zone_id', $ids);
    }

    public function scopeByName($query, string $name){
        return $query->where('name','like',"%$name%");
    }

}
