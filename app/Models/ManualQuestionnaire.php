<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ManualQuestionnaire extends Model
{
    protected $fillable = [
        'vehicle_id',
        'filled_in'
    ];
}
