<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Chat extends Model
{
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
