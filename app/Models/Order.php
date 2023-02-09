<?php

namespace App\Models;

use EloquentFilter\Filterable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Order
 *
 * @package Focus API
 *
 *
 * @OA\Schema(
 *     title="Order model",
 *     description="Order model",
 * )
 */

class Order extends Model
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
     *     property="vehicle_id",
     *     type="integer",
     *     format="int64",
     *     description="Vehicle ID",
     *     title="Vehicle ID",
     * )
     *
     * @OA\Property(
     *     property="workshop_id",
     *     type="integer",
     *     format="int64",
     *     description="Workshop ID",
     *     title="Workshop ID",
     * )
     *
     * @OA\Property(
     *     property="state_id",
     *     type="integer",
     *     format="int64",
     *     description="State ID",
     *     title="State ID",
     * )
     *
     * @OA\Property(
     *     property="type_model_order_id",
     *     type="integer",
     *     format="int64",
     *     description="Type of Model Order ID",
     *     title="Type of Model Order ID",
     * )
     *
     * @OA\Property(
     *     property="id_gsp",
     *     type="integer",
     *     format="int32",
     *     description="ID GSP",
     *     title="ID GSP",
     * )
     *
     * @OA\Property(
     *     property="id_gsp_peritacion",
     *     type="integer",
     *     format="int32",
     *     description="ID GSP Expert Opinion",
     *     title="ID GSP Expertise",
     * )
     *
     * @OA\Property(
     *     property="fx_entrada",
     *     type="string",
     *     format="date-time",
     *     description="FX Entry",
     *     title="FX Entry",
     * )
     *
     * @OA\Property(
     *     property="fx_fallo_check",
     *     type="string",
     *     format="date-time",
     *     description="FX Failed Check",
     *     title="FX Failed Check",
     * )
     *
     * @OA\Property(
     *     property="fx_first_budget",
     *     type="string",
     *     format="date-time",
     *     description="FX First Budget",
     *     title="FX First Budget",
     * )
     *
     * @OA\Property(
     *     property="fx_prevista_reparacion",
     *     type="string",
     *     format="date-time",
     *     description="FX Planned Repair",
     *     title="FX Planned Repair",
     * )
     *
     * @OA\Property(
     *     property="id_gsp_certificado",
     *     type="integer",
     *     format="int32",
     *     description="ID GSP Certified",
     *     title="ID GSP Certified",
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

    use Filterable, HasFactory;

    protected $fillable = [
        'vehicle_id',
        'workshop_id',
        'state_id',
        'type_model_order_id',
        'id_gsp',
        'id_gsp_peritacion',
        'id_gsp_certificado',
        'fx_entrada',
        'fx_fallo_check',
        'fx_first_budget',
        'fx_prevista_reparacion',
    ];

    public function vehicle(){
        return $this->belongsTo(Vehicle::class);
    }

    public function workshop(){
        return $this->belongsTo(Workshop::class);
    }

    public function state(){
        return $this->belongsTo(State::class);
    }

    public function typeModelOrder(){
        return $this->belongsTo(TypeModelOrder::class);
    }

    public function scopeByStateIds($query, array $ids){
        return $query->whereIn('state_id', $ids);
    }

    public function scopeByWorkshopId($query, int $id){
        return $query->where('workshop_id', $id);
    }

    public function scopeByIds($query, array $ids){
        return $query->whereIn('id', $ids);
    }

    public function scopeByVehiclePlate($query, string $plate){
        return $query->whereHas('vehicle', function(Builder $builder) use($plate){
            return $builder->where('plate','like',"%$plate%");
        });
    }
}
