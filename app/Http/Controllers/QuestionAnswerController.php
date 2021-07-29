<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\QuestionnaireController;
use App\Models\QuestionAnswer;
use App\Repositories\QuestionAnswerRepository;
use Symfony\Component\HttpFoundation\Response as HttpFoundationResponse;

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

        $this->validate($request, [
            'vehicle_id' => 'required|integer',
            'questions' => 'required'
        ]);

        return $this->createDataResponse($this->questionAnswerRepository->create($request), HttpFoundationResponse::HTTP_OK);
    }

    public function update(Request $request, $id){
        return $this->updateDataResponse($this->questionAnswerRepository->update($request, $id), HttpFoundationResponse::HTTP_OK);
    }
}
