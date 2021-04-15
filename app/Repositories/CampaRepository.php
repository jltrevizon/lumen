<?php

namespace App\Repositories;

use App\Models\Campa;
use Illuminate\Database\Eloquent\Builder;

class CampaRepository {

    public function __construct()
    {

    }

    public function getCampasByRegion($request){
        return Campa::with(['province.region'])
                    ->whereHas('province', function (Builder $builder) use($request){
                        return $builder->where('region_id', $request->json()->get('region_id'));
                    })
                    ->where('company_id', $request->json()->get('company_id'))
                    ->get();
    }

    public function create($request){
        $campa = new Campa();
        $campa->company_id = $request->json()->get('company_id');
        if($request->json()->get('province_id')) $campa->province_id = $request->json()->get('province_id');
        $campa->name = $request->json()->get('name');
        if($request->json()->get('location')) $campa->location = $request->json()->get('location');
        if($request->json()->get('address')) $campa->address = $request->json()->get('address');
        $campa->save();
        return $campa;
    }

    public function update($request, $id){
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



}
