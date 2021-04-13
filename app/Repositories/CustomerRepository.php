<?php

namespace App\Repositories;

use App\Models\Customer;

class CustomerRepository {

    public function __construct()
    {

    }

    public function create($request){
        $customer = new Customer();
        $customer->name = $request->get('name');
        if(isset($request['province_id'])) $customer->province_id = $request->get('province_id');
        if(isset($request['cif'])) $customer->cif = $request->get('cif');
        if(isset($request['phone'])) $customer->phone = $request->get('phone');
        if(isset($request['address'])) $customer->address = $request->get('address');
        $customer->save();
        return $customer;
    }

    public function update($request, $id){
        $customer = Customer::where('id', $id)
                        ->first();
        if(isset($request['name'])) $customer->name = $request->get('name');
        if(isset($request['cif'])) $customer->cif = $request->get('cif');
        if(isset($request['phone'])) $customer->phone = $request->get('phone');
        if(isset($request['address'])) $customer->address = $request->get('address');
        $customer->updated_at = date('Y-m-d H:i:s');
        $customer->save();
        return $customer;
    }
}
