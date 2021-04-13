<?php

namespace App\Repositories;

use App\Models\DefleetVariable;

class DefleetVariableRepository {

    public function __construct()
    {

    }

    public function updateVariables($request){
        $variables = DefleetVariable::first();
        if($request->json()->get('kms')) $variables->kms = $request->json()->get('kms');
        if($request->json()->get('years')) $variables->years = $request->json()->get('years');
        $variables->save();
        return $variables;
    }

}
