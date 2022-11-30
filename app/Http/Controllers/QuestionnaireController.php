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
    *     @OA\Parameter(
    *         name="id",
    *         in="path",
    *         required=true,
    *         @OA\Schema(
    *             type="string"
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
