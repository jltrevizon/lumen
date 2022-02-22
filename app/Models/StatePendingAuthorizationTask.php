<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class StatePendingAuthorizationTask extends Model
{
    
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name'
    ];

    protected $casts = [
        'name' => 'string'
    ];

    protected $dates = [
        'deleted_at'
    ];
}
