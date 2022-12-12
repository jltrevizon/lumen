<?php

namespace App\Models;

use EloquentFilter\Filterable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Incidence Image
 *
 * @package Focus API
 *
 *
 * @OA\Schema(
 *     title="Incidence image model",
 *     description="Incidence image model",
 * )
 */

class IncidenceImage extends Model
{

    /**
     * @OA\Schema(
    *      schema="IncidenceImagePaginate",
    *      allOf = {
    *          @OA\Schema(ref="#/components/schemas/Paginate"),
    *          @OA\Schema(
    *              @OA\Property(
    *                  property="data",
    *                  type="array",
    *                  @OA\Items(ref="#/components/schemas/IncidenceImage"),
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
     *     property="incidence_id",
     *     type="integer",
     *     format="int64",
     *     description="Incidence ID",
     *     title="Incidence ID",
     * )
     *
     * @OA\Property(
     *     property="comment_id",
     *     type="integer",
     *     format="int64",
     *     description="Comment ID",
     *     title="Comment ID",
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
        'incidence_id',
        'comment_id',
        'url'
    ];

    public function incidence(){
        return $this->belongsTo(Incidence::class);
    }

    public function comment(){
        return $this->belongsTo(Comment::class);
    }

    public function scopeByIds($query, array $ids){
        return $query->whereIn('id', $ids);
    }

    public function scopeByIncidenceIds($query, array $ids){
        return $query->whereIn('incidence_id', $ids);
    }

    public function scopeByCommentIds($query, array $ids){
        return $query->whereIn('comment_id', $ids);
    }

}
