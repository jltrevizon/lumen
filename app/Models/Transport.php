<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Reservation;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class Transport
 *
 * @package Focus API
 *
 *
 * @OA\Schema(
 *     title="Transport model",
 *     description="Transport model",
 * )
 */

class Transport extends Model
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

    protected $fillable = [
        'name'
    ];

    public function reservations(){
        return $this->hasMany(Reservation::class, 'transport_id');
    }
}
