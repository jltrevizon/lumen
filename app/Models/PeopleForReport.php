<?php

namespace App\Models;

use EloquentFilter\Filterable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Class People for Report
 *
 * @package Focus API
 *
 *
 * @OA\Schema(
 *     title="People for Report model",
 *     description="People for Report model",
 * )
 */

class PeopleForReport extends Model
{

    /**
     * @OA\Schema(
    *      schema="PeopleForReportPaginate",
    *      allOf = {
    *          @OA\Schema(ref="#/components/schemas/Paginate"),
    *          @OA\Schema(
    *              @OA\Property(
    *                  property="data",
    *                  type="array",
    *                  @OA\Items(ref="#/components/schemas/PeopleForReport"),
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
     *     property="user_id",
     *     type="integer",
     *     format="int64",
     *     description="User ID",
     *     title="User ID",
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
     *     property="type_report_id",
     *     type="integer",
     *     format="int64",
     *     description="Type of Report ID",
     *     title="Type of Report ID",
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
        'user_id',
        'campa_id',
        'type_report_id'
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function campa(){
        return $this->belongsTo(Campa::class);
    }

    public function typeReport(){
        return $this->belongsTo(TypeReport::class);
    }

    public function scopeByIds($query, array $ids){
        return $query->whereIn('id', $ids);
    }

    public function scopeByUserIds($query, array $ids){
        return $query->whereIn('user_id', $ids);
    }

    public function scopeByTypeReportIds($query, array $ids){
        return $query->whereIn('type_report_id', $ids);
    }

}
