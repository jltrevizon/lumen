<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Request;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class State Request
 *
 * @package Focus API
 *
 *
 * @OA\Schema(
 *     title="State Request model",
 *     description="State Request model",
 * )
 */

class StateRequest extends Model
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
     *     property="name",
     *     type="string",
     *     description="Name",
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

    use HasFactory;

    const REQUESTED = 1;
    const APPROVED = 2;
    const DECLINED = 3;

    protected $fillable = [
        'name'
    ];

    public function requests(){
        return $this->hasMany(Request::class, 'state_request_id');
    }
}
