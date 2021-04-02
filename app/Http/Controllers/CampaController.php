<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Campa;

class CampaController extends Controller
{
    public function getAll(){
        return Campa::all();
    }

    public function getById($id){
        return Campa::where('id', $id)
                    ->first();
    }

    public function create(Request $request){
        $campa = new Campa();
        $campa->company_id = $request->get('company_id');
        if(isset($request['province_id'])) $campa->province_id = $request->get('province_id');
        $campa->name = $request->get('name');
        if(isset($request['location'])) $campa->location = $request->get('location');
        if(isset($request['address'])) $campa->address = $request->get('address');
        $campa->save();
        return $campa;
    }

    public function update(Request $request, $id){
        $campa = Campa::where('id', $id)
                    ->first();
        if(isset($request['company_id'])) $campa->company_id = $request->get('company_id');
        if(isset($request['province_id'])) $campa->province_id = $request->get('province_id');
        if(isset($request['name'])) $campa->name = $request->get('name');
        if(isset($request['location'])) $campa->location = $request->get('location');
        if(isset($request['address'])) $campa->address = $request->get('address');
        if(isset($request['active'])) $campa->active = $request->get('active');
        $campa->save();
        return $campa;
    }

    public function delete($id){
        Campa::where('id', $id)
            ->delete();

        return [
            'message' => 'Campa deleted'
        ];
    }
}
