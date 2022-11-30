<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Type Delivery Note
 *
 * @package Focus API
 *
 *
 * @OA\Schema(
 *     title="Type Delivery Note model",
 *     description="Type Delivery Note model",
 * )
 */

class TypeDeliveryNote extends Model
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

    const DELIVERY = 1;
    const EXIT = 2;

    protected $fillable = [
        'description'
    ];

    protected $casts = [
        'description' => 'string'
    ];

    public function deliveryNotes(){
        return $this->hasMany(DeliveryNote::class);
    }

}
