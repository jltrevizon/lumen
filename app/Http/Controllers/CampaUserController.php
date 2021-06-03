<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CampaUserController extends Controller
{
    public function create(Request $request){
        $campas = $request->json()->get('campas');
        foreach($campas as $campa){
            DB::table('campa_user')->insert([
                'campa_id' => $campa,
                'user_id' => $request->json()->get('user_id')
            ]);
        }
        return User::with(['campas'])
                    ->where('id', $request->json()->get('user_id'))
                    ->first();
    }
}
