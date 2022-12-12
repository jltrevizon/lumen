<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Password Reset Code
 *
 * @package Focus API
 *
 *
 * @OA\Schema(
 *     title="Password Reset Code model",
 *     description="Password Reset Code model",
 * )
 */

class PasswordResetCode extends Model
{

    /**
     * @OA\Schema(
    *      schema="PasswordResetCodePaginate",
    *      allOf = {
    *          @OA\Schema(ref="#/components/schemas/Paginate"),
    *          @OA\Schema(
    *              @OA\Property(
    *                  property="data",
    *                  type="array",
    *                  @OA\Items(ref="#/components/schemas/PasswordResetCode"),
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
     *     property="code",
     *     type="integer",
     *     format="int32",
     *     description="Code",
     *     title="Code",
     * )
     *
     * @OA\Property(
     *     property="active",
     *     type="boolean",
     *     description="Active",
     *     title="Status",
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
        'user_id',
        'code',
        'active'
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function scopeByIds($query, array $ids){
        return $query->whereIn('id', $ids);
    }

    public function scopeByUserIds($query, array $ids){
        return $query->whereIn('user_id', $ids);
    }

    public function scopeByActive($query, bool $active){
        return $query->where('active', $active);
    }
}
