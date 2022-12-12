<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Region;
use App\Models\Campa;
use App\Models\Customer;
use EloquentFilter\Filterable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class Province
 *
 * @package Focus API
 *
 *
 * @OA\Schema(
 *     title="Province model",
 *     description="Province model",
 * )
 */

class Province extends Model
{

    /**
     * @OA\Schema(
    *      schema="ProvincePaginate",
    *      allOf = {
    *          @OA\Schema(ref="#/components/schemas/Paginate"),
    *          @OA\Schema(
    *              @OA\Property(
    *                  property="data",
    *                  type="array",
    *                  @OA\Items(ref="#/components/schemas/Province"),
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
     *     property="region_id",
     *     type="integer",
     *     format="int64",
     *     description="Region ID",
     *     title="Region ID",
     * )
     *
     * @OA\Property(
     *     property="province_code",
     *     type="string",
     *     description="Province Code",
     *     title="Province Code",
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
        'region_id',
        'province_code',
        'name'
    ];

    public function region(){
        return $this->belongsTo(Region::class, 'region_id');
    }

    public function campas(){
        return $this->hasMany(Campa::class, 'province_id');
    }

    public function customers(){
        return $this->hasMany(Customer::class, 'province_id');
    }

    public function scopeByIds($query, array $ids){
        return $query->whereIn('id', $ids);
    }

    public function scopeByRegionIds($query, array $ids){
        return $query->whereIn('region_id', $ids);
    }

    public function scopeByProvinceCode($query, string $code){
        return $query->where('province_code','like',"%$code%");
    }

    public function scopeByName($query, string $name){
        return $query->where('name','like',"%$name%");
    }
}
