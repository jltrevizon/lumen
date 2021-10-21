<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Questionnaire extends Model
{

    use HasFactory;

    protected $fillable = [
        'user_id',
        'vehicle_id',
        'file'
    ];

    public function vehicle(){
        return $this->belongsTo(Vehicle::class);
    }

    public function questionAnswers(){
        return $this->hasMany(QuestionAnswer::class);
    }
}
