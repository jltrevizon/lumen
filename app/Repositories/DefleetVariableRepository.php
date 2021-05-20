<?php

namespace App\Repositories;

use App\Models\DefleetVariable;
use App\Repositories\UserRepository;
use Illuminate\Support\Facades\Auth;

class DefleetVariableRepository {

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function getVariables(){
        $user = $this->userRepository->getById(Auth::id());
        return DefleetVariable::where('company_id', $user['campa']['company_id'])
                    ->first();
    }

    public function createVariables($request){
        $user = $this->userRepository->getById(Auth::id());
        $variables = DefleetVariable::where('company_id', $user['campa']['company_id'])
                                    ->first();
        if($variables){
            return [
                'message' => 'Ya existen variables de defleet para esta empresa'
            ];
        }

        $variables = new DefleetVariable();
        $variables->company_id = $user['campa']['company_id'];
        $variables->kms = $request->json()->get('kms');
        $variables->years = $request->json()->get('years');
        $variables->save();
        return $variables;
    }

    public function updateVariables($request){
        $user = $this->userRepository->getById(Auth::id());
        $variables = DefleetVariable::where('company_id', $user['campa']['company_id'])
                                    ->first();
        if(!$variables){
            return [
                'message' => 'No hay registros que actualizar'
            ];
        }
        if($request->json()->get('kms')) $variables->kms = $request->json()->get('kms');
        if($request->json()->get('years')) $variables->years = $request->json()->get('years');
        $variables->save();
        return $variables;
    }

    public function getVariablesByCompany($company_id){
        return DefleetVariable::where('company_id', $company_id)
                            ->first();
    }

}
