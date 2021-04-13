<?php

namespace App\Http\Controllers;

use App\Models\DefleetVariable;
use Illuminate\Http\Request;
use App\Repositories\DefleetVariableRepository;

class DefleetVariableController extends Controller
{

    public function __construct(DefleetVariableRepository $defleetVariableRepository)
    {
        $this->defleetVariablesRepository = $defleetVariableRepository;
    }

    public function getVariables(){
        return DefleetVariable::first();
    }

    public function updateVariables(Request $request){
        return $this->defleetVariablesRepository->updateVariables($request);
    }
}
