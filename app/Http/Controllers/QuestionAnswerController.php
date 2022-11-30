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

        return $this->createDataResponse($this->questionAnswerRepository->create($request), HttpFoundationResponse::HTTP_CREATED);
    }

    public function createChecklist(Request $request){

        $this->validate($request, [
            'vehicle_id' => 'required|integer',
            'questions' => 'required'
        ]);

        return $this->createDataResponse($this->questionAnswerRepository->createChecklist($request), HttpFoundationResponse::HTTP_CREATED);
    }

    /**
     * @OA\Put(
     *     path="/question-answers/update/{id}",
     *     tags={"question-answers"},
     *     summary="Updated question answer",
     *     @OA\RequestBody(
     *         description="Updated question answer object",
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/QuestionAnswer")
     *     ),
     *     operationId="updateQuestionAnswer",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="id that to be updated",
     *         required=true,
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(ref="#/components/schemas/QuestionAnswer"),
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Question answer not found"
     *     ),
     * )
     */

    public function update(Request $request, $id){
        return $this->updateDataResponse($this->questionAnswerRepository->update($request, $id), HttpFoundationResponse::HTTP_OK);
    }

    /**
     * @OA\Put(
     *     path="/question-answers/update-response/{id}",
     *     tags={"question-answers"},
     *     summary="Updated question answer",
     *     @OA\RequestBody(
     *         description="Updated question answer object",
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/QuestionAnswer")
     *     ),
     *     operationId="updateQuestionAnswer",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="id that to be updated",
     *         required=true,
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(ref="#/components/schemas/QuestionAnswer"),
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Question answer not found"
     *     ),
     * )
     */
    
    public function updateResponse(Request $request, $id){
        return $this->updateDataResponse($this->questionAnswerRepository->updateResponse($request, $id), HttpFoundationResponse::HTTP_OK);
    }
}
