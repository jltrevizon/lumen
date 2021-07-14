<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Questionnaire extends Model
{

    use HasFactory;

    public function vehicle(){
        return $this->belongsTo(Questionnaire::class);
    }

    public function questionAnswers(){
        return $this->hasMany(QuestionAnswer::class);
    }
}
