<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuestionAnswer extends Model
{

    use HasFactory;

    protected $fillable = [
        "task_id",
        "questionnaire_id",
        "question_id",
        "response",
        "description"
    ];

    public function questionnaire(){
        return $this->belongsTo(Questionnaire::class);
    }

    public function question(){
        return $this->belongsTo(Question::class);
    }

    public function task(){
        return $this->belongsTo(Task::class);
    }
}
