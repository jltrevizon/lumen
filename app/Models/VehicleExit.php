<?php

namespace App\Models;

use EloquentFilter\Filterable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Vehicle Exit
 *
 * @package Focus API
 *
 *
 * @OA\Schema(
 *     title="Vehicle Exit model",
 *     description="Vehicle Exit model",
 * )
 */

class VehicleExit extends Model
{

    /**
     * @OA\Schema(
     *      schema="VehicleExitPaginate",
     *      allOf = {
     *          @OA\Schema(ref="#/components/schemas/Paginate"),
     *          @OA\Schema(
     *              @OA\Property(
     *                  property="data",
     *                  type="array",
     *                  @OA\Items(ref="#/components/schemas/VehicleExit"),
     *              ),
     *          ),
     *      },
     * )
     *
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
     *     property="campa_id",
     *     type="integer",
     *     format="int64",
     *     description="Campa ID",
     *     title="Campa ID",
     * )
     *
     * @OA\Property(
     *     property="pending_task_id",
     *     type="integer",
     *     format="int64",
     *     description="Pending Task ID",
     *     title="Pending Task ID",
     * )
     *
     * @OA\Property(
     *     property="delivery_note_id",
     *     type="integer",
     *     format="int64",
     *     description="Delivery Note ID",
     *     title="Delivery Note ID",
     * )
     *
     * @OA\Property(
     *     property="delivery_to",
     *     type="string",
     *     description="Delivery to",
     *     title="Delivery to",
     * )
     *
     * @OA\Property(
     *     property="name_place",
     *     type="string",
     *     description="Name place",
     *     title="Name place",
     * )
     *
     * @OA\Property(
     *     property="is_rolling",
     *     type="boolean",
     *     description="Is Rolling",
     *     title="Is Rolling",
     * )
     *
     * @OA\Property(
     *     property="date_delivery",
     *     type="string",
     *     format="date-time",
     *     description="Date delivery",
     *     title="Date delivery",
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
        'vehicle_id',
        'campa_id',
        'pending_task_id',
        'delivery_note_id',
        'delivery_by',
        'delivery_to',
        'name_place',
        'is_rolling',
        'date_delivery',
        'canceled_by'
    ];

    public function vehicle(){
        return $this->belongsTo(Vehicle::class);
    }

    public function pendingTask(){
        return $this->belongsTo(PendingTask::class);
    }

    public function deliveryNote(){
        return $this->belongsTo(DeliveryNote::class);
    }

    public function campa(){
        return $this->belongsTo(Campa::class);
    }
}
