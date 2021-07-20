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
            $customer = Customer::create($request->all());
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
