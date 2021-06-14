<?php

namespace App\Repositories;

use App\Models\Province;
use Exception;

class ProvinceRepository {

    public function getById($id){
        try {
            return response()->json(['povince' => Province::findOrFail($id)]);
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], 409);
        }
    }

    public function provinceByRegion($request){
        try {
            return Province::where('region_id', $request->input('region_id'))
                        ->get();
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], 409);
        }
    }

    public function create($request){
        try {
            $province = new Province();
            $province->region_id = $request->input('region_id');
            $province->province_code = $request->input('province_code');
            $province->name = $request->input('name');
            $province->save();
            return $province;
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], 409);
        }
    }

    public function update($request, $id){
        try {
            $province = Province::findOrFail($id);
            $province->update($request->all());
            return response()->json(['province' => $province], 200);
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], 409);
        }
    }

    public function delete($id){
        try {
            Province::where('id', $id)
                    ->delete();
            return [
                'message' => 'Province deleted'
            ];
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], 409);
        }
    }
}
