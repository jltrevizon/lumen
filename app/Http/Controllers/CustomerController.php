<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Customer;
use App\Repositories\CustomerRepository;

class CustomerController extends Controller
{

    public function __construct(CustomerRepository $customerRepository)
    {
        $this->customerRepository = $customerRepository;
    }

    public function getAll(){
        return Customer::all();
    }

    public function getById($id){
        return Customer::where('id', $id)
                    ->first();
    }

    public function create(Request $request){
        return $this->customerRepository->create($request);
    }

    public function update(Request $request, $id){
        return $this->customerRepository->update($request, $id);
    }

    public function delete($id){
        Customer::where('id', $id)
            ->delete();

        return [
            'message' => 'Customer deleted'
        ];
    }
}
