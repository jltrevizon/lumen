<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NotifyDamage extends Model
{
 
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'task_id'
    ];

}
