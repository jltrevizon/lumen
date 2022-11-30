<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Workshop
 *
 * @package Focus API
 *
 *
 * @OA\Schema(
 *     title="Workshop model",
 *     description="Workshop model",
 * )
 */

class Workshop extends Model
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
     *     property="cif",
     *     type="string",
     *     description="CIF",
     *     title="CIF",
     * )
     *
     * @OA\Property(
     *     property="address",
     *     type="string",
     *     description="Address",
     *     title="Address",
     * )
     *
     * @OA\Property(
     *     property="location",
     *     type="string",
     *     description="Location",
     *     title="Location",
     * )
     *
     * @OA\Property(
     *     property="province",
     *     type="string",
     *     description="Province",
     *     title="Province",
     * )
     *
     * @OA\Property(
     *     property="phone",
     *     type="integer",
     *     format="int32",
     *     description="Phone",
     *     title="Phone",
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
        'name',
        'cif',
        'address',
        'location',
        'province',
        'phone'
    ];

    public function orders(){
        return $this->hasMany(Order::class);
    }
}
