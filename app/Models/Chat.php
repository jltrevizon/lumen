<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Chat extends Model
{
    public function user_sender(){
        return $this->belongsTo(User::class, 'user_sender');
    }

    public function user_receiver(){
        return $this->belongsTo(User::class, 'user_receiver');
    }

}
