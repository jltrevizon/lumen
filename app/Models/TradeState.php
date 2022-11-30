<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Vehicle;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class Trade State
 *
 * @package Focus API
 *
 *
 * @OA\Schema(
 *     title="Trade State model",
 *     description="Trade State model",
 * )
 */

class TradeState extends Model
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

    const RESERVED = 1;
    const PRE_RESERVED = 2;
    const RESERVED_PRE_DELIVERY = 3;
    const REQUEST_DEFLEET = 4;

    public function vehicles(){
        return $this->hasMany(Vehicle::class, 'trade_state_id');
    }
}
