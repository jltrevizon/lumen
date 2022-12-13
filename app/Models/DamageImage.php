<?php

namespace App\Models;

use EloquentFilter\Filterable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Damage Image
 *
 * @package Focus API
 *
 *
 * @OA\Schema(
 *     title="Damage image model",
 *     description="Damage image model",
 * )
 */

class DamageImage extends Model
{

    /**
     * @OA\Schema(
     *      schema="DamageImagePaginate",
     *      allOf = {
     *          @OA\Schema(ref="#/components/schemas/Paginate"),
     *          @OA\Schema(
     *              @OA\Property(
     *                  property="data",
     *                  type="array",
     *                  @OA\Items(ref="#/components/schemas/DamageImage"),
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
     *     property="damage_id",
     *     type="integer",
     *     format="int64",
     *     description="Damage ID",
     *     title="Damage ID",
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
     *  @OA\Property(
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
        'damage_id',
        'comment_id',
        'url',
    ];

    public function damage(){
        return $this->belongsTo(Damage::class);
    }

    public function comment(){
        return $this->belongsTo(Comment::class);
    }

    public function scopeByIds($query, array $ids){
        return $query->whereIn('id', $ids);
    }

    public function scopeByDamageIds($query, array $ids){
        return $query->whereIn('damage_id', $ids);
    }

}
