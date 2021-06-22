<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class QuestionAnswer extends Model
{
    protected $fillable = [
        "questionnaire_id",
        "question_id",
        "response",
        "description"
    ];

    public function questionnaire(){
        return $this->belongsTo(Questionnaire::class);
    }

    public function questions(){
        return $this->belongsTo(Question::class);
    }
}
