<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Vehicle;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class Vehicle Picture
 *
 * @package Focus API
 *
 *
 * @OA\Schema(
 *     title="Vehicle Picture model",
 *     description="Vehicle Picture model",
 * )
 */

class VehiclePicture extends Model
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
     *     property="user_id",
     *     type="integer",
     *     format="int64",
     *     description="User ID",
     *     title="User ID",
     * )
     *
     * @OA\Property(
     *     property="reception_id",
     *     type="integer",
     *     format="int64",
     *     description="Reception ID",
     *     title="Reception ID",
     * )
     *
     * @OA\Property(
     *     property="url",
     *     type="string",
     *     description="URL",
     *     title="URL",
     * )
     *
     * @OA\Property(
     *     property="plate",
     *     type="string",
     *     description="Plate",
     *     title="Plate",
     * )
     *
     * @OA\Property(
     *     property="latitude",
     *     type="string",
     *     description="Latitude",
     *     title="Latitude",
     * )
     *
     * @OA\Property(
     *     property="longitude",
     *     type="string",
     *     description="Longitude",
     *     title="Longitude",
     * )
     *
     * @OA\Property(
     *     property="active",
     *     type="boolean",
     *     description="Active",
     *     title="Active",
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
        'vehicle_id',
        'user_id',
        'reception_id',
        'url',
        'place',
        'latitude',
        'longitude',
        'active'
    ];

    public function vehicle(){
        return $this->belongsTo(Vehicle::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function reception(){
        return $this->belongsTo(Reception::class);
    }
}
