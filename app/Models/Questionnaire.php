<?php

namespace App\Models;

use EloquentFilter\Filterable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Questionnaire extends Model
{

    use HasFactory, Filterable;

    protected $fillable = [
        'user_id',
        'vehicle_id',
        'reception_id',
        'file'
    ];

    public function vehicle(){
        return $this->belongsTo(Vehicle::class);
    }

    public function reception(){
        return $this->belongsTo(Reception::class);
    }

    public function questionAnswers(){
        return $this->hasMany(QuestionAnswer::class);
    }

    public function groupTask(){
        return $this->hasOne(GroupTask::class);
    }
}
