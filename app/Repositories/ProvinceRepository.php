<?php

namespace App\Repositories;

use App\Models\Province;
use Exception;

class ProvinceRepository {

    public function getById($id){
        return ['povince' => Province::findOrFail($id)];
    }

    public function provinceByRegion($request){
        return Province::where('region_id', $request->input('region_id'))
                    ->get();
    }

    public function create($request){
        $province = Province::create($request->all());
        $province->save();
        return $province;
    }

    public function update($request, $id){
        $province = Province::findOrFail($id);
        $province->update($request->all());
        return ['province' => $province];
    }

    public function delete($id){
        Province::where('id', $id)
                ->delete();
        return [ 'message' => 'Province deleted' ];
    }
}
