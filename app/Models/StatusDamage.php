<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Class State Damage
 *
 * @package Focus API
 *
 *
 * @OA\Schema(
 *     title="State Damage model",
 *     description="State Damage model",
 * )
 */

class StatusDamage extends Model
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
     *     property="description",
     *     type="string",
     *     description="Description",
     *     title="Description",
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

    const OPEN = 1;
    const CLOSED = 2;
    const DECLINED = 3;

    protected $fillable = [
        'description'
    ];

    public function damages(){
        return $this->hasMany(Damage::class);
    }

}
