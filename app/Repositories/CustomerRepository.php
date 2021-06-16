<?php

namespace App\Repositories;

use App\Models\Customer;
use Exception;

class CustomerRepository {

    public function __construct()
    {

    }

    public function create($request){
        try {
            $customer = new Customer();
            $customer->name = $request->input('name');
            if($request->input('company_id')) $customer->company_id = $request->input('company_id');
            if($request->input('province_id')) $customer->province_id = $request->input('province_id');
            if($request->input('cif')) $customer->cif = $request->input('cif');
            if($request->input('phone')) $customer->phone = $request->input('phone');
            if($request->input('address')) $customer->address = $request->input('address');
            $customer->save();
            return $customer;
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], 409);
        }
    }

    public function update($request, $id){
        try {
            $customer = Customer::findOrFail($id);
            $customer->update($request->all());
            return response()->json(['customer' => $customer]);
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], 409);
        }
    }

    public function getUserByCompany($request){
        try {
            return Customer::where('company_id', $request->input('company_id'))
                        ->get();
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], 409);
        }
    }
}
