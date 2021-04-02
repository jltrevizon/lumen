<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Request;

class StateRequest extends Model
{
    public function requests(){
        return $this->hasMany(Request::class, 'state_request_id');
    }
}
