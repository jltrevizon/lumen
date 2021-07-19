<?php

namespace App\Http\Controllers;

use App\Repositories\ManualQuestionnaireRepository;
use Illuminate\Http\Request;

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

        return $this->manualQuestionnaireRepository->create($request);
    }

}
