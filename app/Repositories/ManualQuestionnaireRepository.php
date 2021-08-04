<?php

namespace App\Repositories;

use App\Models\ManualQuestionnaire;
use Exception;

class ManualQuestionnaireRepository {

    public function __construct()
    {

    }

    public function create($request){
        $manual_questionnaire = ManualQuestionnaire::create($request->all());
        $manual_questionnaire->save();
        return $manual_questionnaire;
    }
}
