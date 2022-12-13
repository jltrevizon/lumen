<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Pending Download
 *
 * @package Focus API
 *
 *
 * @OA\Schema(
 *     title="Pending Download model",
 *     description="Pending Download model",
 * )
 */

class PendingDownload extends Model
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
     *     property="user_id",
     *     type="integer",
     *     format="int64",
     *     description="User ID",
     *     title="User ID",
     * )
     *
     * @OA\Property(
     *     property="type_document",
     *     type="string",
     *     description="Type of Document",
     *     title="Type of Document",
     * )
     *
     * @OA\Property(
     *     property="sended",
     *     type="boolean",
     *     description="Sended",
     *     title="Sended",
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
     * 
     */

    use HasFactory;

    protected $fillable = [
        'user_id',
        'type_document',
        'sended'
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }
}
