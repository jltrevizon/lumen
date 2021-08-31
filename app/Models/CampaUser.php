<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CampaUser extends Model
{

    use HasFactory;

    protected $fillable = [
        'campa_id',
        'user_id'
    ];

}
