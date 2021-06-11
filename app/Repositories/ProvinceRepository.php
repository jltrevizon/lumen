<?php

namespace App\Repositories;

use App\Models\Province;
use Exception;

class ProvinceRepository {

    public function getById($id){
        try {
            return Province::where('id', $id)
                            ->first();
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], 409);
        }
    }

    public function provinceByRegion($request){
        try {
            return Province::where('region_id', $request->json()->get('region_id'))
                        ->get();
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], 409);
        }
    }

    public function create($request){
        try {
            $province = new Province();
            $province->region_id = $request->json()->get('region_id');
            $province->province_code = $request->json()->get('province_code');
            $province->name = $request->json()->get('name');
            $province->save();
            return $province;
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], 409);
        }
    }

    public function update($request, $id){
        try {
            $province = Province::where('id', $id)
                                ->first();
            if($request->json()->get('name')) $province->name = $request->json()->get('name');
            if($request->json()->get('region_id')) $province->region_id = $request->json()->get('region_id');
            if($request->json()->get('province_code')) $province->province_code = $request->json()->get('province_code');
            $province->updated_at = date('Y-m-d H:i:s');
            $province->save();
            return $province;
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
