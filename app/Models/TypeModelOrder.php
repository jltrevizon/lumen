<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TypeModelOrder extends Model
{

    const BIPI = 1;
    const REDRIVE = 2;
    const D2 = 3;

    protected $fillable = [
        'name'
    ];
}
