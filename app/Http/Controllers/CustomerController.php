<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Customer;

class CustomerController extends Controller
{
    public function getAll(){
        return Customer::all();
    }

    public function getById($id){
        return Customer::where('id', $id)
                    ->first();
    }

    public function create(Request $request){
        $customer = new Customer();
        $customer->name = $request->get('name');
        if(isset($request['province_id'])) $customer->province_id = $request->get('province_id');
        if(isset($request['cif'])) $customer->cif = $request->get('cif');
        if(isset($request['phone'])) $customer->phone = $request->get('phone');
        if(isset($request['address'])) $customer->address = $request->get('address');
        $customer->save();
        return $customer;
    }

    public function update(Request $request, $id){
        $customer = Customer::where('id', $id)
                        ->first();
        if(isset($request['name'])) $customer->name = $request->get('name');
        if(isset($request['cif'])) $customer->cif = $request->get('cif');
        if(isset($request['phone'])) $customer->phone = $request->get('phone');
        if(isset($request['address'])) $customer->address = $request->get('address');
        $customer->save();
        return $customer;
    }

    public function delete($id){
        Customer::where('id', $id)
            ->delete();

        return [
            'message' => 'Customer deleted'
        ];
    }
}
