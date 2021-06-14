<?php

namespace App\Repositories;

use App\Models\ManualQuestionnaire;
use Exception;

class ManualQuestionnaireRepository {

    public function __construct()
    {

    }

    public function create($request){
        try {
            $manual_questionnaire = new ManualQuestionnaire();
            $manual_questionnaire->vehicle_id = $request->input('vehicle_id');
            $manual_questionnaire->filled_in = $request->input('filled_in');
            $manual_questionnaire->save();
            return $manual_questionnaire;
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], 409);
        }
    }
}
