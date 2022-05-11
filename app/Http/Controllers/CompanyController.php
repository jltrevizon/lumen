<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Company;
use App\Repositories\CompanyRepository;
use Symfony\Component\HttpFoundation\Response as HttpFoundationResponse;

class CompanyController extends Controller
{

    public function __construct(CompanyRepository $companyRepository)
    {
        $this->companyRepository = $companyRepository;
    }

    public function index(Request $request){
        return $this->getDataResponse($this->companyRepository->index($request), HttpFoundationResponse::HTTP_OK);
    }

    public function show($id){
        return $this->getDataResponse($this->companyRepository->show($id), HttpFoundationResponse::HTTP_OK);
    }

    public function create(Request $request){

        $this->validate($request, [
            'name' => 'required|string'
        ]);

        return $this->createDataResponse($this->companyRepository->create($request), HttpFoundationResponse::HTTP_CREATED);
    }

    public function update(Request $request, $id){
        return $this->updateDataResponse($this->companyRepository->update($request, $id), HttpFoundationResponse::HTTP_OK);
    }

    public function delete($id){
        Company::where('id', $id)
            ->delete();

        return [ 'message' => 'Company deleted' ];
    }
}
