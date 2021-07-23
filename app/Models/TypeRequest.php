<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Request;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TypeRequest extends Model
{

    use HasFactory;

    const DEFLEET = 1;
    const RESERVATION = 2;

    public function requests(){
        return $this->hasMany(Request::class, 'type_request_id');
    }
}
