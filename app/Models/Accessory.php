<?php

namespace App\Models;

use EloquentFilter\Filterable;
use Spatie\Activitylog\LogOptions;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class Accessory
 *
 * @package Focus API
 *
 *
 * @OA\Schema(
 *     title="Accessory model",
 *     description="Accessory model",
 * )
 */

class Accessory extends Model
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
     *     property="accessory_type_id",
     *     type="integer",
     *     format="int64",
     *     description="Type of the accessory id",
     *     title="Type of Accessory ID",
     * )
     *
     * @OA\Property(
     *     property="name",
     *     type="string",
     *     description="Name of the accessory",
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
    use HasFactory, Filterable, LogsActivity;

    const ACCESSORY = 1;
    const DOCUMENTATION = 2;

    protected $fillable = [
        'accessory_type_id',
        'name'
    ];
    protected static $recordEvents = ['created', 'updated','deleted'];

    public function accessoryType(){
        return $this->belongsTo(AccessoryType::class);
    }

    public function vehicles(){
        return $this->belongsToMany(Vehicle::class);
    }

    public function scopeByIds($query, array $ids){
        return $query->whereIn('id', $ids);
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
        ->logOnly([ 'accessory_type_id',
        'name'])->useLogName('accessory');
        
    }

}
