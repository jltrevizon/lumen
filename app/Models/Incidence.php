<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\PendingTask;
use EloquentFilter\Filterable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class Incidence
 *
 * @package Focus API
 *
 *
 * @OA\Schema(
 *     title="Incidence model",
 *     description="Incidence model",
 * )
 */

class Incidence extends Model
{

    /**
     * @OA\Schema(
    *      schema="IncidencePaginate",
    *      allOf = {
    *          @OA\Schema(ref="#/components/schemas/Paginate"),
    *          @OA\Schema(
    *              @OA\Property(
    *                  property="data",
    *                  type="array",
    *                  @OA\Items(ref="#/components/schemas/Incidence"),
    *              ),
    *          ),
    *      },
    * )
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
     *     property="incidence_type_id",
     *     type="integer",
     *     format="int64",
     *     description="Type of Incidence ID",
     *     title="Type of Incidence ID",
     * )
     *
     * @OA\Property(
     *     property="description",
     *     type="string",
     *     description="Description",
     *     title="Description",
     * )
     *
     * @OA\Property(
     *     property="read",
     *     type="boolean",
     *     description="Read",
     *     title="Read",
     * )
     *
     * @OA\Property(
     *     property="resolved",
     *     type="boolean",
     *     description="Resolved",
     *     title="Resolved",
     * )
     */

    use HasFactory, Filterable;

    protected $fillable = [
        'vehicle_id',
        'incidence_type_id',
        'description',
        'read',
        'resolved'
    ];

    public function pending_tasks(){
        return $this->belongsToMany(PendingTask::class);
    }

    public function incidenceType(){
        return $this->belongsTo(IncidenceType::class);
    }

    public function vehicle(){
        return $this->belongsTo(Vehicle::class);
    }

    public function comments(){
        return $this->hasMany(Comment::class);
    }

    public function pendingAuthorizations(){
        return $this->hasMany(PendingAuthorization::class);
    }

    public function incidenceImages(){
        return $this->hasMany(IncidenceImage::class);
    }

    public function scopeByIds($query, array $ids){
        return $query->whereIn('id', $ids);
    }

    public function scopeByResolved($query, bool $resolved){
        return $query->where('resolved', $resolved);
    }

    public function scopeByVehicleIds($query, array $ids){
        return $query->whereIn('id', $ids);
    }

    public function scopeByPlate($query, string $plate){
        return $query->whereHas('vehicle', function(Builder $builder) use($plate){
            return $builder->where('plate','like',"%$plate%");
        });
    }

    public function scopeByRead($query, bool $read){
        return $query->where('read', $read);
    }
}
