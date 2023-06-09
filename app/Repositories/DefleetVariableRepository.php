<?php

namespace App\Repositories;

use App\Models\DefleetVariable;
use App\Repositories\UserRepository;
use Exception;
use Illuminate\Support\Facades\Auth;

class DefleetVariableRepository extends Repository{

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function getAll($request){
        return DefleetVariable::with($this->getWiths($request->with))
                ->filter($request->all())
                ->paginate();
    }

    public function getVariables($request){
        $user = $this->userRepository->getById($request, Auth::id());
        return DefleetVariable::where('company_id', $user['company_id'])
                    ->first();
    }

    public function createVariables($request){
        $user = $this->userRepository->getById($request, Auth::id());
        $variables = DefleetVariable::byCompany($user['company_id'])->first();
        if($variables) return [ 'message' => 'Ya existen variables de defleet para esta empresa' ];
        $variables = new DefleetVariable();
        $variables->company_id = $user['company_id'];
        $variables->kms = $request->input('kms');
        $variables->years = $request->input('years');
        $variables->save();
        return $variables;
    }

    public function updateVariables($request){
        $user = $this->userRepository->getById($request, Auth::id());
        $variables = DefleetVariable::byCompany($user['company_id'])->first();
        if(!$variables) return [ 'message' => 'No hay registros que actualizar' ];
        $variables->update($request->all());
        return ['variables' => $variables];
    }

    public function getVariablesByCompany($company_id){
        return DefleetVariable::where('company_id', $company_id)
                            ->first();
    }

}
