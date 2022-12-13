<?php

namespace App\Models;

use EloquentFilter\Filterable;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Campa Type Model Order
 *
 * @package Focus API
 *
 *
 * @OA\Schema(
 *     title="Campa type model order model",
 *     description="Campa type model order model",
 * )
 */

class CampaTypeModelOrder extends Model
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
     *     property="campa_id",
     *     type="integer",
     *     format="int64",
     *     description="Campa ID",
     *     title="Campa ID",
     * )
     *
     * @OA\Property(
     *     property="type_model_order_id",
     *     type="integer",
     *     format="int64",
     *     description="Type of Model Order ID",
     *     title="Type of Model Order ID",
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

    use Filterable;

    protected $fillable = [
        'campa_id',
        'type_model_order_id'
    ];

    public function campa(){
        return $this->belongsTo(Campa::class, 'campa_id');
    }

    public function typeModelOrder(){
        return $this->belongsTo(TypeModelOrder::class, 'type_model_order_id');
    }
}
