<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Campa;
use App\Models\ReservationTime;
use App\Models\Customer;
use EloquentFilter\Filterable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class Company
 *
 * @package Focus API
 *
 *
 * @OA\Schema(
 *     title="Company model",
 *     description="Company model",
 * )
 */

class Company extends Model
{

    /**
     * @OA\Schema(
     *      schema="CompanyWithSubStateAndTypeTask",
     *      allOf = {
     *          @OA\Schema(ref="#/components/schemas/Company"),
     *          @OA\Schema(
     *              @OA\Property(
     *                  property="sub_state",
     *                  type="object",
     *                  ref="#/components/schemas/SubStateWithState"
     *              ),
     *          ),
     *          @OA\Schema(
     *              @OA\Property(
     *                  property="type_task",
     *                  type="object",
     *                  ref="#/components/schemas/TypeTask"
     *              ),
     *          ),
     *      },
     * )
     * @OA\Schema(
    *      schema="CompanyPaginate",
    *      allOf = {
    *          @OA\Schema(ref="#/components/schemas/Paginate"),
    *          @OA\Schema(
    *              @OA\Property(
    *                  property="data",
    *                  type="array",
    *                  @OA\Items(ref="#/components/schemas/CompanyWithSubStateAndTypeTask"),
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
     *     property="name",
     *     type="string",
     *     description="Name",
     *     title="Name",
     * )
     *
     * @OA\Property(
     *     property="tradename",
     *     type="string",
     *     description="Tradename",
     *     title="Tradename",
     * )
     *
     * @OA\Property(
     *     property="nif",
     *     type="string",
     *     description="Nif",
     *     title="Nif",
     * )
     *
     * @OA\Property(
     *     property="address",
     *     type="string",
     *     description="Address",
     *     title="Address",
     * )
     *
     * @OA\Property(
     *     property="location",
     *     type="string",
     *     description="Location",
     *     title="Location",
     * )
     *
     * @OA\Property(
     *     property="phone",
     *     type="integer",
     *     format="int32",
     *     description="Phone",
     *     title="Phone",
     * )
     *
     * @OA\Property(
     *     property="logo",
     *     type="string",
     *     description="Logo",
     *     title="Logo",
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
     *     description="When was created",
     *     title="Updated at",
     * )
     */

    use HasFactory, Filterable;

    const ALD = 1;
    const INVARAT = 2;

    protected $fillable = [
        'name',
        'tradename',
        'nif',
        'address',
        'location',
        'phone',
        'logo'
    ];

    public function campas(){
        return $this->hasMany(Campa::class);
    }

    public function reservationTimes(){
        return $this->hasMany(ReservationTime::class);
    }

    public function customers(){
        return $this->hasMany(Customer::class);
    }

    public function users(){
        return $this->hasMany(User::class);
    }

    public function questions(){
        return $this->hasMany(Question::class);
    }

    public function defleetVariable(){
        return $this->hasOne(DefleetVariable::class);
    }

    public function states(){
        return $this->hasMany(State::class);
    }

    public function scopeByIds($query, array $ids){
        return $query->whereIn('id', $ids);
    }

    public function scopeByName($query, string $name){
        return $query->where('name','like',"%$name%");
    }

    public function scopeByNif($query, string $nif){
        return $query->where('nif','like',"%$nif%");
    }

    public function scopeByPhone($query, int $phone){
        return $query->where('phone','like',"%$phone%");
    }
}
