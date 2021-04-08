<?php

namespace App\Http\Controllers;

use App\Models\DefleetVariable;
use Illuminate\Http\Request;

class DefleetVariableController extends Controller
{
    public function getVariables(){
        return DefleetVariable::first();
    }

    public function updateVariables(Request $request){
        $variables = DefleetVariable::first();
        if($request->json()->get('kms')) $variables->kms = $request->json()->get('kms');
        if($request->json()->get('years')) $variables->years = $request->json()->get('years');
        $variables->save();
        return $variables;
    }
}
