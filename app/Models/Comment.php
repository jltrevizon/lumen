<?php

namespace App\Models;

use EloquentFilter\Filterable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Comment
 *
 * @package Focus API
 *
 *
 * @OA\Schema(
 *     title="Comment model",
 *     description="Comment model",
 * )
 */

class Comment extends Model
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
     *     property="damage_id",
     *     type="integer",
     *     format="int64",
     *     description="Damage ID",
     *     title="Damage ID",
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
     *     property="description",
     *     type="string",
     *     format="int64",
     *     description="User ID",
     *     title="User ID",
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
        'user_id',
        'description'
    ];

    public function damage(){
        return $this->belongsTo(Damage::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function incidenceImages(){
        return $this->hasMany(IncidenceImage::class);
    }

    public function damageImages(){
        return $this->hasMany(DamageImage::class);
    }

    public function scopeByIds($query, array $ids){
        return $query->whereIn('id', $ids);
    }

    public function scopeByDamageIds($query, array $ids){
        return $query->whereIn('damage_id', $ids);
    }

    public function scopeByUserIds($query, array $ids){
        return $query->whereIn('user_id', $ids);
    }

}
