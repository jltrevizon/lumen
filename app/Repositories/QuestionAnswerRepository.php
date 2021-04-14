<?php

namespace App\Repositories;

use App\Models\QuestionAnswer;

class QuestionAnswerRepository {

    public function __construct()
    {

    }

    public function create($request){
        $questionnaire = $this->questionnaireController->create($request->json()->get('vehicle_id'));
        $questions = $request->json()->get('questions');
        foreach($questions as $question){
            $questionAnswer = new QuestionAnswer();
            $questionAnswer->questionnaire_id = $questionnaire;
            $questionAnswer->question_id = $question['question_id'];
            $questionAnswer->response = $question['response'];
            $questionAnswer->description = $question['description'];
            $questionAnswer->save();
        }
        return [
            'message' => 'Ok'
        ];
    }
}
