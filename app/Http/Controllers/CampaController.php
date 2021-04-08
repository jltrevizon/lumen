<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Campa;

class CampaController extends Controller
{
    public function getAll(){
        return Campa::with(['province', 'company'])
                    ->get();
    }

    public function getById($id){
        return Campa::with(['province','company'])
                    ->where('id', $id)
                    ->first();
    }

    public function getByCompany(Request $request){
        return Campa::with(['company'])
                    ->where('company_id', $request->json()->get('company_id'))
                    ->get();
    }

    public function create(Request $request){
        $campa = new Campa();
        $campa->company_id = $request->json()->get('company_id');
        if($request->json()->get('province_id')) $campa->province_id = $request->json()->get('province_id');
        $campa->name = $request->json()->get('name');
        if($request->json()->get('location')) $campa->location = $request->json()->get('location');
        if($request->json()->get('address')) $campa->address = $request->json()->get('address');
        $campa->save();
        return $campa;
    }

    public function update(Request $request, $id){
        $campa = Campa::where('id', $id)
                    ->first();
        if($request->json()->get('company_id')) $campa->company_id = $request->json()->get('company_id');
        if($request->json()->get('province_id')) $campa->province_id = $request->json()->get('province_id');
        if($request->json()->get('name')) $campa->name = $request->json()->get('name');
        if($request->json()->get('location')) $campa->location = $request->json()->get('location');
        if($request->json()->get('address')) $campa->address = $request->json()->get('address');
        if($request->json()->get('active')) $campa->active = $request->json()->get('active');
        $campa->updated_at = date('Y-m-d H:i:s');
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
