<?php

namespace App\Http\Controllers;

use App\Models\Questionnaire;
use App\Repositories\QuestionnaireRepository;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response as HttpFoundationResponse;

class QuestionnaireController extends Controller
{

    public function __construct(QuestionnaireRepository $questionnaireRepository)
    {
        $this->questionnaireRepository = $questionnaireRepository;
    }

    /**
    * @OA\Get(
    *     path="/api/questionnaire/",
    *     tags={"questionnaire"},
    *     summary="Get all questionnaires",
    *     security={
    *          {"bearerAuth": {}}
    *     },
    *     @OA\Parameter(
    *       name="with[]",
    *       in="query",
    *       description="A list of relatonship",
    *       required=false,
    *       @OA\Schema(
    *           type="array",
    *           example={"relationship1","relationship2"},
    *           @OA\Items(type="string")
    *       )
    *     ),
    *     @OA\Parameter(
    *       name="per_page",
    *       in="query",
    *       description="Items per page",
    *       required=false,
    *       @OA\Schema(
    *           type="integer",
    *           example=5,
    *       )
    *     ),
    *     @OA\Parameter(
    *       name="page",
    *       in="query",
    *       description="Page",
    *       required=false,
    *       @OA\Schema(
    *           type="integer",
    *           example=1,
    *       )
    *     ),
    *     @OA\Response(
    *         response=200,
    *         description="Successful operation",
    *         @OA\Items(ref="#/components/schemas/QuestionnairePaginate")
    *     ),
    *     @OA\Response(
    *         response="500",
    *         description="An error has occurred."
    *     )
    * )
    */

    public function index(Request $request){
        return $this->getDataResponse($this->questionnaireRepository->index($request), HttpFoundationResponse::HTTP_OK);
    }

    public function create($vehicle_id){
        return $this->createDataResponse($this->questionnaireRepository->create($vehicle_id), HttpFoundationResponse::HTTP_CREATED);
    }

    /**
    * @OA\Get(
    *     path="/api/questionnaire/{id}",
    *     tags={"questionnaires"},
    *     summary="Get questionnaire by ID",
    *     security={
    *          {"bearerAuth": {}}
    *     },
    *     @OA\Parameter(
    *       name="with[]",
    *       in="query",
    *       description="A list of relatonship",
    *       required=false,
    *       @OA\Schema(
    *           type="array",
    *           example={"relationship1","relationship2"},
    *           @OA\Items(type="string")
    *       )
    *     ),
    *     @OA\Parameter(
    *         name="id",
    *         in="path",
    *         required=true,
    *         @OA\Schema(
    *             type="integer"
    *         )
    *     ),
    *     @OA\Response(
    *         response=200,
    *         description="Successful operation",
    *         @OA\JsonContent(ref="#/components/schemas/Questionnaire"),
    *    ),
    *     @OA\Response(
    *         response="404",
    *         description="Questionnaire not found."
    *     )
    * )
    */
    public function getById(Request $request, $id){
        return $this->getDataResponse($this->questionnaireRepository->getById($request, $id));
    }
}
