<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Delivery Note
 *
 * @package Focus API
 *
 *
 * @OA\Schema(
 *     title="Delivery Note model",
 *     description="Delivery Note model",
 * )
 */

class DeliveryNote extends Model
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
     *     property="type_delivery_note_id",
     *     type="integer",
     *     format="int64",
     *     description="Type of Delivery Note ID",
     *     title="Type of Delivery Note ID",
     * )
     *
     * @OA\Property(
     *     property="body",
     *     type="string",
     *     description="Body",
     *     title="Body",
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
        'type_delivery_note_id',
        'body'
    ];

    protected $casts = [
        'body' => 'array'
    ];

    public function typeDeliveyNote(){
        return $this->belongsTo(TypeDeliveryNote::class);
    }
}
