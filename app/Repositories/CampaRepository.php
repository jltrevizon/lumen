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
                            return $builder->where('region_id', $request->input('region_id'));
                        })
                        ->where('company_id', $request->input('company_id'))
                        ->get();
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], 409);
        }
    }

    public function getCampasByProvince($request){
        try {
            return Campa::with(['province'])
                        ->where('province_id', $request->input('province_id'))
                        ->where('company_id', $request->input('company_id'))
                        ->get();
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], 409);
        }
    }

    public function create($request){
        try {
            $campa = new Campa();
            $campa->company_id = $request->input('company_id');
            if($request->input('province_id')) $campa->province_id = $request->input('province_id');
            $campa->name = $request->input('name');
            if($request->input('location')) $campa->location = $request->input('location');
            if($request->input('address')) $campa->address = $request->input('address');
            $campa->save();
            return $campa;
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], 409);
        }
    }

    public function update($request, $id){
        try {
            $campa = Campa::findOrFail($id);
            $campa->update($request->all());
            return response()->json(['campa' => $campa], 200);
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], 409);
        }
    }



}
