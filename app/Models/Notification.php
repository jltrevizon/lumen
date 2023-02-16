<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Notification extends Model
{
    protected $table = "notifications";
    protected $perPage = 5;

    public function to_user()
    {
        return $this->belongsTo(User::class, 'notifiable_id');
    }

    public function notification()
    {
        return $this->morphTo();
    }
}
