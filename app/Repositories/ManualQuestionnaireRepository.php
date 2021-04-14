<?php

namespace App\Repositories;

use App\Models\ManualQuestionnaire;

class ManualQuestionnaireRepository {

    public function __construct()
    {

    }

    public function create($vehicle_id, $reponse){
        $manual_questionnaire = new ManualQuestionnaire();
        $manual_questionnaire->vehicle_id = $vehicle_id;
        $manual_questionnaire->response = $reponse;
        $manual_questionnaire->save();
        return $manual_questionnaire;
    }
}
