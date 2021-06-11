<?php

namespace App\Repositories;

use App\Models\Questionnaire;
use Exception;

class QuestionnaireRepository {

    public function __construct()
    {

    }

    public function create($vehicle_id){
        try {
            $questionnaire = new Questionnaire();
            $questionnaire->vehicle_id = $vehicle_id;
            $questionnaire->save();
            return $questionnaire->id;
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], 409);
        }
    }
}
