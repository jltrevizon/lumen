<?php

namespace App\Repositories;

use App\Models\Province;

class ProvinceRepository {

    public function getById($id){
        return Province::where('id', $id)
                        ->first();
    }

    public function provinceByRegion($request){
        return Province::where('region_id', $request->json()->get('region_id'))
                    ->get();
    }

    public function create($request){
        $province = new Province();
        $province->region_id = $request->get('region_id');
        $province->province_code = $request->get('province_code');
        $province->name = $request->get('name');
        $province->save();
        return $province;
    }

    public function update($request, $id){
        $province = Province::where('id', $id)
                            ->first();
        if(isset($request['name'])) $province->name = $request->get('name');
        if(isset($request['region_id'])) $province->region_id = $request->get('region_id');
        if(isset($request['province_code'])) $province->province_code = $request->get('province_code');
        $province->updated_at = date('Y-m-d H:i:s');
        $province->save();
        return $province;
    }

    public function delete($id){
        Province::where('id', $id)
                ->delete();
        return [
            'message' => 'Province deleted'
        ];
    }
}
