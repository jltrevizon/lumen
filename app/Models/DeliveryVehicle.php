<?php

namespace App\Models;

use EloquentFilter\Filterable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Delivery Vehicle
 *
 * @package Focus API
 *
 *
 * @OA\Schema(
 *     title="Delivery vehicle model",
 *     description="Delivery Vehicle model",
 * )
 */

class DeliveryVehicle extends Model
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
     *     property="pending_task_id",
     *     type="integer",
     *     format="int64",
     *     description="Pending Task ID",
     *     title="Pending Task ID",
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
     *     property="delivery_note_id",
     *     type="integer",
     *     format="int64",
     *     description="Delivery Note ID",
     *     title="Delivery Note ID",
     * )
     *
     * @OA\Property(
     *     property="data_delivery",
     *     type="string",
     *     description="Data Delivery",
     *     title="Data Delivery",
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
     *
     * @OA\Property(
     *     property="delivery_by",
     *     type="string",
     *     description="Delivery by",
     *     title="Delivery by",
     * )
     *
     * @OA\Property(
     *     property="canceled_by",
     *     type="string",
     *     description="Canceled by",
     *     title="Canceled by",
     * )
     */

    use HasFactory, Filterable, SoftDeletes;

    protected $fillable = [
        'pending_task_id',
        'vehicle_id',
        'campa_id',
        'delivery_note_id',
        'data_delivery',
        'delivery_by',
        'canceled_by',
    ];

    protected $casts = [
    	'vehicle_id' => 'integer',
        'campa_id' => 'integer',
        'delivery_note_id' => 'integer',
    	'data_delivery' => 'json',
        'delivery_by' => 'string',
        'canceled_by' => 'string'
    ];

    protected $dates = [
        'deleted_at'
    ];

    public function scopeByIds($query, $ids){
        return $query->whereIn('id', $ids);
    }

    public function vehicle(){
        return $this->belongsTo(Vehicle::class);
    }

    public function pendingTask(){
        return $this->belongsTo(PendingTask::class);
    }

    public function typeModelOrder(){
        return $this->belongsTo(TypeModelOrder::class);
    }

    public function campa(){
        return $this->belongsTo(Campa::class);
    }

    public function deliveryNote(){
        return $this->belongsTo(DeliveryNote::class);
    }
}
