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


    /**
     * @OA\Post(
     *     path="/api/question-answers",
     *     tags={"question-answers"},
     *     summary="Create question answer",
     *     security={
     *          {"bearerAuth": {}}
     *     },
     *     operationId="createQuestionAnswer",
     *     @OA\RequestBody(
     *         description="Create questionnaire object",
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/QuestionAnswer"),
     *     ),
     *     @OA\Response(
     *         response="201",
     *         description="Successful operation",
     *         @OA\JsonContent(ref="#/components/schemas/Questionnaire"),
     *     ),
     *
     * )
     */

    public function create(Request $request){

        $this->validate($request, [
            'vehicle_id' => 'required|integer',
            'questions' => 'required'
        ]);

        return $this->createDataResponse($this->questionAnswerRepository->create($request), HttpFoundationResponse::HTTP_CREATED);
    }

    /**
     * @OA\Post(
     *     path="/api/question-answers/checklist",
     *     tags={"question-answers"},
     *     summary="Create checklist",
     *     security={
     *          {"bearerAuth": {}}
     *     },
     *     operationId="createChecklist",
     *     @OA\RequestBody(
     *         description="Create checklist",
     *         required=true,
     *         value= @OA\JsonContent(
     *              @OA\Property(
     *                  property="vehicle_id",
     *                  type="integer",
     *              ),
     *              @OA\Property(
     *                  property="questions",
     *                  type="string",
     *              ),
     *         ),
     *     ),
     *     @OA\Response(
     *         response="201",
     *         description="Successful operation",
     *         @OA\JsonContent(ref="#/components/schemas/Questionnaire"),
     *     ),
     * )
     */

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
     *     security={
     *          {"bearerAuth": {}}
     *     },
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
     *     security={
     *          {"bearerAuth": {}}
     *     },
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
     *         response="200",
     *         description="Successful operation",
     *         @OA\JsonContent(ref="#/components/schemas/QuestionAnswer"),
     *     ),
     *     @OA\Response(
     *         response="404",
     *         description="Question answer not found"
     *     ),
     * )
     */

    public function updateResponse(Request $request, $id){
        return $this->updateDataResponse($this->questionAnswerRepository->updateResponse($request, $id), HttpFoundationResponse::HTTP_OK);
    }
}
