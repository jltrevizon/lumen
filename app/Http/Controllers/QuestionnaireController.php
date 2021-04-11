<?php

namespace App\Http\Controllers;

use App\Models\Questionnaire;
use Illuminate\Http\Request;

class QuestionnaireController extends Controller
{
    public function create($vehicle_id){
        $questionnaire = new Questionnaire();
        $questionnaire->vehicle_id = $vehicle_id;
        $questionnaire->save();
        return $questionnaire->id;
    }
}
