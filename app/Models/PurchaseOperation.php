<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Task;

class PurchaseOperation extends Model
{
    public function task(){
        return $this->belongsTo(Task::class, 'task_id');
    }
}
