<?php

namespace App\Repositories;

use App\Models\Customer;
use Exception;

class CustomerRepository {

    public function __construct()
    {

    }

    public function getAll(){
        return Customer::all();
    }

    public function getById($id){
        return Customer::findOrFail($id);
    }

    public function create($request){
        $customer = Customer::create($request->all());
        $customer->save();
        return $customer;
    }

    public function update($request, $id){
        $customer = Customer::findOrFail($id);
        $customer->update($request->all());
        return ['customer' => $customer];
    }

    public function getUserByCompany($request){
        return Customer::byCompany($request->input('company_id'))
                    ->get();
    }
}
