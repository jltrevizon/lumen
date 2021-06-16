<?php

namespace App\Repositories;

use App\Models\DefleetVariable;
use App\Repositories\UserRepository;
use Exception;
use Illuminate\Support\Facades\Auth;

class DefleetVariableRepository {

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function getVariables(){
        try {
            $user = $this->userRepository->getById(Auth::id());
            return DefleetVariable::where('company_id', $user['campa']['company_id'])
                        ->first();
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], 409);
        }
    }

    public function createVariables($request){
        try {
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
            $variables->kms = $request->input('kms');
            $variables->years = $request->input('years');
            $variables->save();
            return $variables;
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], 409);
        }
    }

    public function updateVariables($request){
        try {
            $user = $this->userRepository->getById(Auth::id());
            $variables = DefleetVariable::where('company_id', $user['campa']['company_id'])
                                        ->first();
            if(!$variables){
                return [
                    'message' => 'No hay registros que actualizar'
                ];
            }
            $variables->update($request->all());
            return response()->json(['variables' => $variables], 200);
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], 409);
        }
    }

    public function getVariablesByCompany($company_id){
        try {
            return DefleetVariable::where('company_id', $company_id)
                                ->first();
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], 409);
        }
    }

}
