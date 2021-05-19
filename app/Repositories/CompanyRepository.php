<?php

namespace App\Repositories;

use App\Models\Company;

class CompanyRepository {

    public function __construct()
    {

    }

    public function create($request){
        $company = new Company();
        $company->name = $request->json()->get('name');
        if($request->json()->get('tradename')) $company->tradename = $request->json()->get('tradename');
        if($request->json()->get('nif')) $company->nif = $request->json()->get('nif');
        if($request->json()->get('address')) $company->address = $request->json()->get('address');
        if($request->json()->get('location')) $company->location = $request->json()->get('location');
        if($request->json()->get('phone')) $company->phone = $request->json()->get('phone');
        if($request->json()->get('logo')) $company->logo = $request->json()->get('logo');
        $company->save();
        return $company;
    }

    public function update($request, $id){
        $company = Company::where('id', $id)
                        ->first();
        if($request->json()->get('name')) $company->name = $request->json()->get('name');
        if($request->json()->get('tradename')) $company->tradename = $request->json()->get('tradename');
        if($request->json()->get('nif')) $company->nif = $request->json()->get('nif');
        if($request->json()->get('address')) $company->address = $request->json()->get('address');
        if($request->json()->get('location')) $company->location = $request->json()->get('location');
        if($request->json()->get('phone')) $company->phone = $request->json()->get('phone');
        if($request->json()->get('logo')) $company->logo = $request->json()->get('logo');
        $company->updated_at = date('Y-m-d H:i:s');
        $company->save();
        return $company;
    }

}
