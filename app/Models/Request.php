<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Vehicle;
use App\Models\StateRequest;
use App\Models\TypeRequest;
use App\Models\Reservation;
use App\Models\Customer;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class Request
 *
 * @package Focus API
 *
 *
 * @OA\Schema(
 *     title="Request model",
 *     description="Request model",
 * )
 */

class Request extends Model
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
     *     property="customer_id",
     *     type="integer",
     *     format="int64",
     *     description="Customer ID",
     *     title="Customer ID",
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
     *     property="state_request_id",
     *     type="integer",
     *     format="int64",
     *     description="State Request ID",
     *     title="State Request ID",
     * )
     *
     * @OA\Property(
     *     property="type_request_id",
     *     type="integer",
     *     format="int64",
     *     description="Type Request ID",
     *     title="Type Request ID",
     * )
     *
     * @OA\Property(
     *     property="datetime_request",
     *     type="string",
     *     format="date-time",
     *     description="Datetime Request",
     *     title="Datetime Request",
     * )
     *
     * @OA\Property(
     *     property="datetime_decline",
     *     type="string",
     *     format="date-time",
     *     description="Datetime Decline",
     *     title="Datetime Decline",
     * )
     *
     * @OA\Property(
     *     property="datetime_approved",
     *     type="string",
     *     format="date-time",
     *     description="Datetime Approved",
     *     title="Datetime Approved",
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
        'customer_id',
        'vehicle_id',
        'state_request_id',
        'type_request_id',
        'datetime_request',
        'datetime_decline'
    ];

    public function vehicle(){
        return $this->belongsTo(Vehicle::class, 'vehicle_id');
    }

    public function state_request(){
        return $this->belongsTo(StateRequest::class, 'state_request_id');
    }

    public function type_request(){
        return $this->belongsTo(TypeRequest::class, 'type_request_id');
    }

    public function reservation(){
        return $this->hasOne(Reservation::class, 'request_id');
    }

    public function customer(){
        return $this->belongsTo(Customer::class, 'customer_id');
    }

    public function scopeByVehicleInCampa($query, int $campaId){
        return $query->whereHas('vehicle', function(Builder $builder) use($campaId) {
            return $builder->where('campa_id', $campaId);
        });
    }

    public function scopeByVehicleInCampas($query, array $campaIds){
        return $query->whereHas('vehicle', function(Builder $builder) use($campaIds) {
            return $builder->whereIn('campa_id', $campaIds);
        });
    }
}
