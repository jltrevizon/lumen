<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Laravel\Lumen\Routing\Controller as BaseController;

class Controller extends BaseController
{
    protected function responseWithToken($token){
        $user = User::with(['role'])
                    ->where('id', Auth::id())
                    ->first();
        return response()->json([
            'token' => $token,
            'token_type' => 'bearer',
            'user' => $user,
            'expires_in' => Auth::factory()->getTTL() * 60
        ], 200);
    }
}
