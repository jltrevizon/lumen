<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\QuestionnaireController;
use App\Models\QuestionAnswer;
use App\Repositories\QuestionAnswerRepository;

class QuestionAnswerController extends Controller
{
    public function __construct(
        QuestionnaireController $questionnaireController,
        QuestionAnswerRepository $questionAnswerRepository)
    {
        $this->questionnaireController = $questionnaireController;
        $this->questionAnswerRepository = $questionAnswerRepository;
    }

    public function create(Request $request){
        return $this->questionAnswerRepository->create($request);
    }
}
