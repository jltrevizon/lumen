<?php

namespace App\Repositories;

use App\Models\Questionnaire;
use Exception;

class QuestionnaireRepository extends Repository {

    public function __construct()
    {

    }

    public function create($vehicle_id){
        $questionnaire = new Questionnaire();
        $questionnaire->vehicle_id = $vehicle_id;
        $questionnaire->save();
        return $questionnaire->id;
    }

    public function getById($request, $id){
        return Questionnaire::with($this->getWiths($request->with))
                    ->findOrFail($id);
    }

}
