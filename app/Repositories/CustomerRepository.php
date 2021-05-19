<?php

namespace App\Repositories;

use App\Models\Customer;

class CustomerRepository {

    public function __construct()
    {

    }

    public function create($request){
        $customer = new Customer();
        $customer->name = $request->json()->get('name');
        if($request->json()->get('company_id')) $customer->company_id = $request->json()->get('company_id');
        if($request->json()->get('province_id')) $customer->province_id = $request->json()->get('province_id');
        if($request->json()->get('cif')) $customer->cif = $request->json()->get('cif');
        if($request->json()->get('phone')) $customer->phone = $request->json()->get('phone');
        if($request->json()->get('address')) $customer->address = $request->json()->get('address');
        $customer->save();
        return $customer;
    }

    public function update($request, $id){
        $customer = Customer::where('id', $id)
                        ->first();
        if($request->json()->get('company_id')) $customer->company_id = $request->json()->get('company_id');
        if($request->json()->get('name')) $customer->name = $request->json()->get('name');
        if($request->json()->get('cif')) $customer->cif = $request->json()->get('cif');
        if($request->json()->get('phone')) $customer->phone = $request->json()->get('phone');
        if($request->json()->get('address')) $customer->address = $request->json()->get('address');
        $customer->updated_at = date('Y-m-d H:i:s');
        $customer->save();
        return $customer;
    }

    public function getUserByCompany($request){
        return Customer::where('company_id', $request->json()->get('company_id'))
                    ->get();
    }
}
