<?php

namespace App\Models;

use Spatie\Activitylog\LogOptions;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class Accessory Vehicle Type
 *
 * @package Focus API
 *
 *
 * @OA\Schema(
 *     title="Accessory vehicle model",
 *     description="Accessory vehicle model",
 * )
 */

class AccessoryVehicle extends Model
{

    /**
     * @OA\Property(
     *     property="accessory_id",
     *     type="integer",
     *     format="int64",
     *     description="Accessory ID",
     *     title="Accessory ID",
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
     */
    use HasFactory, LogsActivity;

    protected static $recordEvents = ['created', 'updated','deleted'];

    protected $fillable = [
        'accessory_id',
        'vehicle_id'
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
        ->logOnly([ 'accessory_id',
        'vehicle_id'])->useLogName('vehicle accessory');
        
    }

}
