<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Request as VehicleRequest;
use App\Models\Vehicle;
use App\Models\Transport;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class Reservation
 *
 * @package Focus API
 *
 *
 * @OA\Schema(
 *     title="Reservation model",
 *     description="Reservation model",
 * )
 */

class Reservation extends Model
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
     *     property="request_id",
     *     type="integer",
     *     format="int64",
     *     description="Request ID",
     *     title="Request ID",
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
     *     property="reservation_time",
     *     type="integer",
     *     format="int32",
     *     description="Reservation Time",
     *     title="Reservation Time",
     * )
     *
     * @OA\Property(
     *     property="dni",
     *     type="string",
     *     description="DNI",
     *     title="DNI",
     * )
     *
     * @OA\Property(
     *     property="order",
     *     type="string",
     *     description="Order",
     *     title="Order",
     * )
     *
     * @OA\Property(
     *     property="contract",
     *     type="string",
     *     description="Contract",
     *     title="Contract",
     * )
     *
     * @OA\Property(
     *     property="planned_reservation",
     *     type="string",
     *     format="date-time",
     *     description="Planned Reservation",
     *     title="Planned Reservation",
     * )
     *
     * @OA\Property(
     *     property="pickup_by_customer",
     *     type="boolean",
     *     description="Pickup by Customer",
     *     title="Pickup by Customer",
     * )
     *
     * @OA\Property(
     *     property="transport_id",
     *     type="integer",
     *     format="int64",
     *     description="Transport ID",
     *     title="Transport ID",
     * )
     *
     * @OA\Property(
     *     property="actual_date",
     *     type="string",
     *     format="date-time",
     *     description="Actual Date",
     *     title="Actual Date",
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
     *     property="type_reservation_id",
     *     type="integer",
     *     format="int64",
     *     description="Type of Reservation ID",
     *     title="Type of Reservation ID",
     * )
     *
     * @OA\Property(
     *     property="active",
     *     type="boolean",
     *     description="Active",
     *     title="Status",
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
        'request_id',
        'vehicle_id',
        'reservation_time',
        'dni',
        'order',
        'contract',
        'planned_reservation',
        'pickup_by_customer',
        'transport_id',
        'actual_date',
        'campa_id',
        'type_reservation_id',
        'active'
    ];

    public function request(){
        return $this->belongsTo(VehicleRequest::class, 'request_id');
    }

    public function vehicle(){
        return $this->belongsTo(Vehicle::class, 'vehicle_id');
    }

    public function transport(){
        return $this->belongsTo(Transport::class, 'transport_id');
    }

    public function scopeByCompany($query, int $companyId){
        return $query->whereHas('vehicle.campa', function (Builder $builder) use($companyId){
            return $builder->where('company_id', $companyId);
        });
    }
}
