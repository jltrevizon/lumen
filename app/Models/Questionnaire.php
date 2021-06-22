<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Questionnaire extends Model
{
    public function vehicle(){
        return $this->belongsTo(Questionnaire::class);
    }

    public function questionAnswers(){
        return $this->hasMany(QuestionAnswer::class);
    }
}
