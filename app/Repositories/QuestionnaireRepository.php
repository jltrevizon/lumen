<?php

namespace App\Repositories;

use App\Models\Questionnaire;
use Exception;

class QuestionnaireRepository {

    public function __construct()
    {

    }

    public function create($vehicle_id){
        $questionnaire = new Questionnaire();
        $questionnaire->vehicle_id = $vehicle_id;
        $questionnaire->save();
        return $questionnaire->id;
    }

}
