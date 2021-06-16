<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DefleetVariable extends Model
{

    protected $fillable = [
        'company_id',
        'kms',
        'years'
    ];

}
