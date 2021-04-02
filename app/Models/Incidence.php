<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\PendingTask;

class Incidence extends Model
{
    public function pending_task(){
        return $this->hasOne(PendingTask::class, 'incidence_id');
    }
}
