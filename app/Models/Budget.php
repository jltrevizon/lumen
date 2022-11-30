<?php

namespace App\Models;

use EloquentFilter\Filterable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Budget
 *
 * @package Focus API
 *
 *
 * @OA\Schema(
 *     title="Budget model",
 *     description="Budget model",
 * )
 */

class Budget extends Model
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
     *     property="order_id",
     *     type="integer",
     *     format="int64",
     *     description="Order ID",
     *     title="Order ID",
     * )
     *
     * @OA\Property(
     *     property="sub_total",
     *     type="number",
     *     format="double",
     *     description="Sub total",
     *     title="Sub total",
     * )
     *
     * @OA\Property(
     *     property="tax",
     *     type="number",
     *     format="double",
     *     description="Tax",
     *     title="Tax",
     * )
     *
     * @OA\Property(
     *     property="total",
     *     type="number",
     *     format="double",
     *     description="Total",
     *     title="Total",
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
        'order_id',
        'sub_total',
        'tax',
        'total'
    ];

    public function budgetLines(){
        return $this->hasMany(BudgetLine::class);
    }

    public function vehicle(){
        return $this->belongsTo(Vehicle::class);
    }

    public function scopeByIds($query, $ids){
        return $query->whereIn('id', $ids);
    }

    public function scopeByVehicleIds($query, $ids){
        return $query->whereIn('vehicle_id', $ids);
    }

    public function scopeByOrderIds($query, $ids){
        return $query->whereIn('order_id', $ids);
    }

}
