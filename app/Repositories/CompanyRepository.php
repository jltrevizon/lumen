<?php

namespace App\Repositories;

use App\Models\Company;
use Exception;

class CompanyRepository extends Repository{

    public function __construct()
    {

    }

    public function index($request){
        return Company::with($this->getWiths($request->with))
            ->filter($request->all())
            ->paginate($request->input('per_page'));
    }

    public function show($id){
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
