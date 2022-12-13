<?php

namespace App\Http\Controllers;

use App\Repositories\ManualQuestionnaireRepository;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response as HttpFoundationResponse;

class ManualQuestionnaireController extends Controller
{
    public function __construct(ManualQuestionnaireRepository $manualQuestionnaireRepository)
    {
        $this->manualQuestionnaireRepository = $manualQuestionnaireRepository;
    }

    /**
     * @OA\Post(
     *     path="/api/manual-questionnaire",
     *     tags={"manual-questionnaire"},
     *     summary="Create manual questionnaire",
     *     security={
     *          {"bearerAuth": {}}
     *     },
     *     operationId="createManualQuestionnaire",
     *     @OA\Response(
     *         response="201",
     *         description="Successful operation",
     *         @OA\JsonContent(ref="#/components/schemas/ManualQuestionnaire"),
     *     ),
     *     @OA\RequestBody(
     *         description="Create manual questionnaire object",
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/ManualQuestionnaire"),
     *     )
     * )
     */

    public function create(Request $request){

        $this->validate($request, [
            'vehicle_id' => 'required|integer',
            'filled_in' => 'required'
        ]);

        return $this->createDataResponse($this->manualQuestionnaireRepository->create($request), HttpFoundationResponse::HTTP_OK);
    }

}
