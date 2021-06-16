<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function register(Request $request){

        $this->validate($request, [
            'name' => 'required|string',
            'email' => 'required|email|unique:users',
            'password' => 'required',
        ]);

        try {

            $user = new User;
            $user->name = $request->input('name');
            $user->email = $request->input('email');
            $plainPassword = $request->input('password');
            $user->password = app('hash')->make($plainPassword);
            $user->save();

            return response()->json(['user' => $user, 'message' => 'CREATED'], 201);

        } catch (\Exception $e) {
            return response()->json(['message' => 'User Registration Failed!'], 409);
        }
    }

    public function login(Request $request){

       /* $this->validate($request->json(), [
            'email' => 'required|string',
            'password' => 'required|string',
        ]);*/

        $credentials = ['email' => $request->input('email'), 'password' => $request->input('password')];
        if( !$token = Auth::attempt($credentials)){
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        return $this->responseWithToken($token);
    }
}
