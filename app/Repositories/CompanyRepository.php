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
            $company = new Company();
            $company->name = $request->input('name');
            if($request->input('tradename')) $company->tradename = $request->input('tradename');
            if($request->input('nif')) $company->nif = $request->input('nif');
            if($request->input('address')) $company->address = $request->input('address');
            if($request->input('location')) $company->location = $request->input('location');
            if($request->input('phone')) $company->phone = $request->input('phone');
            if($request->input('logo')) $company->logo = $request->input('logo');
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
