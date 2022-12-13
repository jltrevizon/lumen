<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Vehicle;
use App\Models\SubState;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use EloquentFilter\Filterable;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class State
 *
 * @package Focus API
 *
 *
 * @OA\Schema(
 *     title="State model",
 *     description="State model",
 * )
 */

class State extends Model
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
     *     property="company_id",
     *     type="integer",
     *     format="int64",
     *     description="Company ID",
     *     title="Company ID",
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
     *     property="type",
     *     type="integer",
     *     format="int32",
     *     description="Type",
     *     title="Type",
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

    use HasFactory, Filterable, SoftDeletes;

    const AVAILABLE = 1;
    const WORKSHOP = 2;
    const PENDING_SALE_VO = 3;
    const NOT_AVAILABLE = 4;
    const DELIVERED = 5;
    const PRE_AVAILABLE = 6;
    const PENDING_TEST_DINAMIC_INITIAL = 7;
    const PENDING_INITIAL_CHECK = 8;
    const PENDING_BUDGET = 9;
    const PENDING_AUTHORIZATION = 10;
    const IN_REPAIR = 11;
    const PENDING_TEST_DINAMIC_FINAL = 12;
    const PENDING_FINAL_CHECK = 13;
    const PENDING_CERTIFICATED = 14;
    const FINISHED = 15;
    const TRANSPORT = 16;

    protected $fillable = [
        'name', 'type'
    ];

    public function vehicles(){
        return $this->hasMany(Vehicle::class, 'state_id');
    }

    public function subStates(){
        return $this->hasMany(SubState::class, 'state_id');
    }

    public function orders(){
        return $this->hasMany(Order::class);
    }

    public function scopeByCompany($query, array $ids){
        return $query->whereIn('company_id', $ids);
    }

    public function scopeByType($query, array $ids){
        return $query->whereIn('type', $ids);
    }
}
