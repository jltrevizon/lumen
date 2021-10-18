<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Customer;
use App\Repositories\CustomerRepository;
use Symfony\Component\HttpFoundation\Response as HttpFoundationResponse;

class CustomerController extends Controller
{

    public function __construct(CustomerRepository $customerRepository)
    {
        $this->customerRepository = $customerRepository;
    }

    public function getAll(Request $request){
        return $this->getDataResponse($this->customerRepository->getAll($request), HttpFoundationResponse::HTTP_OK);
    }

    public function getById($id){
        return $this->getDataResponse($this->customerRepository->getById($id), HttpFoundationResponse::HTTP_OK);
    }

    public function create(Request $request){

        $this->validate($request, [
            'name' => 'required|string'
        ]);

        return $this->getDataResponse($this->customerRepository->create($request), HttpFoundationResponse::HTTP_CREATED);
    }

    public function update(Request $request, $id){
        return $this->updateDataResponse($this->customerRepository->update($request, $id), HttpFoundationResponse::HTTP_OK);
    }

    public function getUserByCompany(Request $request){

        $this->validate($request, [
            'company_id' => 'required|integer'
        ]);

        return $this->getDataResponse($this->customerRepository->getUserByCompany($request), HttpFoundationResponse::HTTP_OK);
    }

    public function delete($id){
        Customer::where('id', $id)
            ->delete();

        return [
            'message' => 'Customer deleted'
        ];
    }
}
