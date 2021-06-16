<?php

namespace App\Repositories;

use App\Models\Question;
use App\Models\Region;
use App\Models\User;
use Exception;
use Illuminate\Support\Facades\Auth;

class RegionRepository {

    public function __construct()
    {

    }

    public function getById($id){
        try {
            return Region::where('id', $id)
                            ->first();
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], 409);
        }
    }

    public function create($request){
        try {
            $region = new Region();
            $region->name = $request->input('name');
            $region->save();
            return $region;
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], 409);
        }
    }

    public function update($request, $id){
        try {
            $region = Region::findOrFail($id);
            $region->update($request->all());
            return response()->json(['region' => $region], 200);
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], 409);
        }
    }

    public function delete($id){
        try {
            Region::where('id', $id)
                    ->delete();
            return [
                'message' => 'Region deleted'
            ];
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], 409);
        }
    }
}
