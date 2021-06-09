<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\PendingTask;

class Incidence extends Model
{
    public function pending_tasks(){
        return $this->belongsToMany(PendingTask::class);
    }
}
