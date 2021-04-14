<?php

namespace App\Repositories;

use App\Models\ManualQuestionnaire;

class ManualQuestionnaireRepository {

    public function __construct()
    {

    }

    public function create($request){
        $manual_questionnaire = new ManualQuestionnaire();
        $manual_questionnaire->vehicle_id = $request->json()->get('vehicle_id');
        $manual_questionnaire->filled_in = $request->json()->get('filled_in');
        $manual_questionnaire->save();
        return $manual_questionnaire;
    }
}
