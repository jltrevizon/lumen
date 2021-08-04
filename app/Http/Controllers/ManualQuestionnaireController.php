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

    public function create(Request $request){

        $this->validate($request, [
            'vehicle_id' => 'required|integer',
            'filled_in' => 'required'
        ]);

        return $this->createDataResponse($this->manualQuestionnaireRepository->create($request), HttpFoundationResponse::HTTP_OK);
    }

}
