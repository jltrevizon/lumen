<?php

namespace App\Repositories;

use App\Models\Company;
use Exception;

class CompanyRepository {

    public function __construct()
    {

    }

    public function getAll(){
        return Company::all();
    }

    public function getById($id){
        return Company::findOrFail($id);
    }

    public function create($request){
        $company = Company::create($request->all());
        $company->save();
        return $company;
    }

    public function update($request, $id){
        $company = Company::findOrFail($id);
        $company->update($request->all());
        return ['company' => $company];
    }

}
