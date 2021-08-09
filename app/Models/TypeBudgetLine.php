<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TypeBudgetLine extends Model
{

    const REPLACEMENT = 1;
    const WORKFORCE = 2;
    const PAINTING = 3;

    protected $fillable = [
        'name'
    ];

}
