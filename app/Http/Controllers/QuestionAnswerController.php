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
        $questionAnswer = new QuestionAnswer();
        $questionAnswer->questionnaire_id = $this->questionnaireController->create($request->json()->get('vehicle_id'));
        $questionAnswer->question_id = $request->json()->get('question_id');
        $questionAnswer->response = $request->json()->get('response');
        $questionAnswer->description = $request->json()->get('description');
        $questionAnswer->save();
        return $questionAnswer;
    }
}
