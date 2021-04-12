<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\QuestionnaireController;
use App\Models\QuestionAnswer;

class QuestionAnswerController extends Controller
{
    public function __construct(QuestionnaireController $questionnaireController)
    {
        $this->questionnaireController = $questionnaireController;
    }

    public function create(Request $request){
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
