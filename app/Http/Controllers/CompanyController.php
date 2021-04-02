<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Company;

class CompanyController extends Controller
{
    public function getAll(){
        return Company::all();
    }

    public function getById($id){
        return Company::where('id', $id)
                    ->first();
    }

    public function create(Request $request){
        $company = new Company();
        $company->name = $request->get('name');
        if(isset($request['tradename'])) $company->tradename = $request->get('tradename');
        if(isset($request['nif'])) $company->nif = $request->get('nif');
        if(isset($request['address'])) $company->address = $request->get('address');
        if(isset($request['location'])) $company->location = $request->get('location');
        if(isset($request['phone'])) $company->phone = $request->get('phone');
        if(isset($request['logo'])) $company->logo = $request->get('logo');
        $company->save();
        return $company;
    }

    public function update(Request $request, $id){
        $company = Company::where('id', $id)
                        ->first();
        if(isset($request['name'])) $company->name = $request->get('name');
        if(isset($request['tradename'])) $company->tradename = $request->get('tradename');
        if(isset($request['nif'])) $company->nif = $request->get('nif');
        if(isset($request['address'])) $company->address = $request->get('address');
        if(isset($request['location'])) $company->location = $request->get('location');
        if(isset($request['phone'])) $company->phone = $request->get('phone');
        if(isset($request['logo'])) $company->logo = $request->get('logo');
        $company->save();
        return $company;
    }

    public function delete($id){
        Company::where('id', $id)
            ->delete();

        return [
            'message' => 'Company deleted'
        ];
    }
}
