<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Request;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class Type Request
 *
 * @package Focus API
 *
 *
 * @OA\Schema(
 *     title="Type Request model",
 *     description="Type Request model",
 * )
 */

class TypeRequest extends Model
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

    const DEFLEET = 1;
    const RESERVATION = 2;

    public function requests(){
        return $this->hasMany(Request::class, 'type_request_id');
    }
}
