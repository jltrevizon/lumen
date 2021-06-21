<?php

namespace App\Http\Controllers;

use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CampaUserController extends Controller
{
    public function create(Request $request){
        $campas = $request->input('campas');
        foreach($campas as $campa){
            DB::table('campa_user')->insert([
                'campa_id' => $campa,
                'user_id' => $request->input('user_id')
            ]);
        }
        return User::with(['campas'])
                    ->where('id', $request->input('user_id'))
                    ->first();
    }

    public function delete(Request $request){
        try {
            $campas = $request->input('campas');
            foreach($campas as $campa){
                DB::table('campa_user')
                ->where('user_id',$request->input('user_id'))
                ->where('campa_id', $campa)
                ->delete();
            }
            return response()->json(['message' => 'campas deleted'], 200);
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], 409);
        }
    }
}
