<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CampaUser extends Model
{

    protected $fillable = [
        'campa_id',
        'user_id'
    ];

}
