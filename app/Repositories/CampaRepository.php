<?php

namespace App\Repositories;

use App\Models\Campa;
use Exception;
use Illuminate\Database\Eloquent\Builder;

class CampaRepository {

    public function __construct()
    {

    }

    public function getCampasByRegion($request){
        try {
            return Campa::with(['province.region'])
                        ->whereHas('province', function (Builder $builder) use($request){
                            return $builder->where('region_id', $request->json()->get('region_id'));
                        })
                        ->where('company_id', $request->json()->get('company_id'))
                        ->get();
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], 409);
        }
    }

    public function getCampasByProvince($request){
        try {
            return Campa::with(['province'])
                        ->where('province_id', $request->json()->get('province_id'))
                        ->where('company_id', $request->json()->get('company_id'))
                        ->get();
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], 409);
        }
    }

    public function create($request){
        try {
            $campa = new Campa();
            $campa->company_id = $request->json()->get('company_id');
            if($request->json()->get('province_id')) $campa->province_id = $request->json()->get('province_id');
            $campa->name = $request->json()->get('name');
            if($request->json()->get('location')) $campa->location = $request->json()->get('location');
            if($request->json()->get('address')) $campa->address = $request->json()->get('address');
            $campa->save();
            return $campa;
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], 409);
        }
    }

    public function update($request, $id){
        try {
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
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], 409);
        }
    }



}
