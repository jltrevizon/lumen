<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use EloquentFilter\Filterable;

/**
 * Class Role
 *
 * @package Focus API
 *
 *
 * @OA\Schema(
 *     title="Role model",
 *     description="Role model",
 * )
 */

class Role extends Model
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

    use HasFactory, Filterable;

    const ADMIN = 1;
    const GLOBAL_MANAGER = 2;
    const CAMPA_MANAGET = 3;
    const USER_APP = 4;
    const RECEPTION = 5;
    const COMMERCIAL = 6;
    const CONTROL = 7;
    const MANAGER_MECHANIC = 8;
    const MANAGER_CHAPA = 9;

    protected $fillable = [
        'description'
    ];

    public function users(){
        return $this->hasMany(User::class, 'user_id');
    }

    public function damages(){
        return $this->belongsToMany(Damage::class);
    }

    public function scopeByIds($query, array $ids){
        return $query->whereIn('id', $ids);
    }
}
