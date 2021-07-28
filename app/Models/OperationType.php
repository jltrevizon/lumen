<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OperationType extends Model
{

    const REPAIR = 1;
    const REPLACE = 2;

    protected $fillable = [
        'name'
    ];

}
