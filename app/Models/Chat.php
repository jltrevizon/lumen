<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;

/**
 * Class Chat
 *
 * @package Focus API
 *
 *
 * @OA\Schema(
 *     title="Chat model",
 *     description="Chat model",
 * )
 */

class Chat extends Model
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
     *     property="sent_user_app",
     *     type="boolean",
     *     description="Sent user app",
     *     title="Sent user app",
     * )
     *
     * @OA\Property(
     *     property="message",
     *     type="string",
     *     description="Message",
     *     title="Message",
     * )
     *
     * @OA\Property(
     *     property="read",
     *     type="boolean",
     *     description="Read",
     *     title="Read",
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

    protected $fillable = [
        'campa_id',
        'sent_user_app',
        'message',
        'read'
    ];

    public function user_sender(){
        return $this->belongsTo(User::class, 'user_sender');
    }

    public function user_receiver(){
        return $this->belongsTo(User::class, 'user_receiver');
    }

}
