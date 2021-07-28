<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Task;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TypeTask extends Model
{

    const ACCESSORY = 1;
    const SPECIAL = 2;

    use HasFactory;

    protected $fillable = [
        'name'
    ];

    public function tasks(){
        return $this->hasMany(Task::class, 'type_task_id');
    }
}
