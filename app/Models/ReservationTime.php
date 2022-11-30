<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Company;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class Reservation Time
 *
 * @package Focus API
 *
 *
 * @OA\Schema(
 *     title="Reservation Time model",
 *     description="Reservation Time model",
 * )
 */

class ReservationTime extends Model
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
     *     property="hours",
     *     type="integer",
     *     format="int32",
     *     description="Hours",
     *     title="Hours",
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

    public function company(){
        return $this->belongsTo(Company::class);
    }
}
