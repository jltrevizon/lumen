<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Vehicle Model
 *
 * @package Focus API
 *
 *
 * @OA\Schema(
 *     title="Vehicle Model model",
 *     description="Vehicle Model model",
 * )
 */

class VehicleModel extends Model
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
     *     property="brand_id",
     *     type="integer",
     *     format="int64",
     *     description="Brand ID",
     *     title="Brand ID",
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
        'brand_id',
        'name'
    ];

    public function vehicles(){
        return $this->hasMany(Vehicle::class);
    }

    public function brand(){
        return $this->belongsTo(Brand::class);
    }
}
