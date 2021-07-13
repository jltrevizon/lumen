<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\PendingTask;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Incidence extends Model
{

    use HasFactory;

    protected $fillable = [
        'description',
        'resolved'
    ];

    public function pending_tasks(){
        return $this->belongsToMany(PendingTask::class);
    }
}
