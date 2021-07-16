<?php

namespace App\Repositories;

use App\Models\Company;
use Exception;

class CompanyRepository {

    public function __construct()
    {

    }

    public function create($request){
        try {
            $company = Company::create($request->all());
            $company->save();
            return $company;
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], 409);
        }
    }

    public function update($request, $id){
        try {
            $company = Company::findOrFail($id);
            $company->update($request->all());
            return response()->json(['company' => $company], 200);
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], 409);
        }
    }

}
