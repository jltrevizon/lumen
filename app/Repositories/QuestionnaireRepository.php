<?php

namespace App\Repositories;

use App\Models\Questionnaire;
use Exception;
use Illuminate\Support\Facades\Auth;

class QuestionnaireRepository extends Repository {

    public function __construct()
    {

    }

    public function create($request){
        $questionnaire = Questionnaire::create($request->all());
        $questionnaire->user_id = Auth::id();
        $questionnaire->save();
        return $questionnaire;
    }

    public function getById($request, $id){
        return Questionnaire::with($this->getWiths($request->with))
                    ->findOrFail($id);
    }

}
