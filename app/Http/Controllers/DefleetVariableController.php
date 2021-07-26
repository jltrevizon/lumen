<?php

namespace App\Http\Controllers;

use App\Models\DefleetVariable;
use Illuminate\Http\Request;
use App\Repositories\DefleetVariableRepository;
use Symfony\Component\HttpFoundation\Response as HttpFoundationResponse;

class DefleetVariableController extends Controller
{

    public function __construct(DefleetVariableRepository $defleetVariableRepository)
    {
        $this->defleetVariablesRepository = $defleetVariableRepository;
    }

    public function getVariables(){

        return $this->getDataResponse($this->defleetVariablesRepository->getVariables(), HttpFoundationResponse::HTTP_OK);
    }

    public function createVariables(Request $request){

        $this->validate($request, [
            'kms' => 'required|integer',
            'years' => 'required|integer'
        ]);

        return $this->createDataResponse($this->defleetVariablesRepository->createVariables($request), HttpFoundationResponse::HTTP_CREATED);
    }

    public function updateVariables(Request $request){
        return $this->updateDataResponse($this->defleetVariablesRepository->updateVariables($request), HttpFoundationResponse::HTTP_OK);
    }
}
