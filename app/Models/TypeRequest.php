<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Request;

class TypeRequest extends Model
{
    public function requests(){
        return $this->hasMany(Request::class, 'type_request_id');
    }
}
