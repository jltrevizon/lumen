<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Request;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class StateRequest extends Model
{

    use HasFactory;

    const REQUESTED = 1;
    const APPROVED = 2;
    const DECLINED = 3;

    protected $fillable = [
        'name'
    ];

    public function requests(){
        return $this->hasMany(Request::class, 'state_request_id');
    }
}
