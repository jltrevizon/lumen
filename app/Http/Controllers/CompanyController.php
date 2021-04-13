<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Company;
use App\Repositories\CompanyRepository;

class CompanyController extends Controller
{

    public function __construct(CompanyRepository $companyRepository)
    {
        $this->companyRepository = $companyRepository;
    }

    public function getAll(){
        return Company::all();
    }

    public function getById($id){
        return Company::where('id', $id)
                    ->first();
    }

    public function create(Request $request){
        return $this->companyRepository->create($request);
    }

    public function update(Request $request, $id){
        return $this->companyRepository->update($request, $id);
    }

    public function delete($id){
        Company::where('id', $id)
            ->delete();

        return [ 'message' => 'Company deleted' ];
    }
}
