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



    /**
     * @OA\Post(
     *     path="/api/auth/signin",
     *     tags={"auths"},
     *     summary="Sign In",
     *     operationId="SignIn",
     *     @OA\Response(
     *         response="200",
     *         description="Successful sign in",
     *         value = @OA\JsonContent(
     *              @OA\Property(
     *                  property="code",
     *                  type="integer",
     *              ),
     *              @OA\Property(
     *                  property="expires_in",
     *                  type="integer",
     *              ),
     *              @OA\Property(
     *                  property="token",
     *                  type="string",
     *              ),
     *              @OA\Property(
     *                  property="token_type",
     *                  type="string",
     *              ),
     *              @OA\Property(
     *                  property="user",
     *                  ref="#/components/schemas/UserWithCampasAndRole",
     *              ),
     *          ),
     *     ),
     *     @OA\Response(
     *        response="400",
     *        description="Unauthorized",
     *     ),
     *     @OA\RequestBody(
     *         description="",
     *         required=true,
     *         value = @OA\JsonContent(
     *              required={"email","password"},
     *              @OA\Property(
     *                  property="email",
     *                  type="string",
     *                  format="email"
     *              ),
     *              @OA\Property(
     *                  property="password",
     *                  type="string",
     *                  format="password"
     *              ),
     *         )
     *     )
     * )
     */

    public function login(Request $request){
        $credentials = ['email' => $request->input('email'), 'password' => $request->input('password')];
        if( !$token = Auth::attempt($credentials)){
            $credentials = ['name' => $request->input('email'), 'password' => $request->input('password')];
            if( !$token = Auth::attempt($credentials)){
                return response()->json(['message' => 'Unauthorized'], 401);
            }
            return $this->responseWithToken($token);
        }
        return $this->responseWithToken($token);
    }

    /**
    * @OA\Get(
    *     path="/api/refresh",
    *     tags={"auths"},
    *     summary="Get refresh token",
    *     security={
    *          {"bearerAuth": {}}
    *     },
    *     @OA\Response(
    *         response=200,
    *         description="Successful operation",
    *         value = @OA\JsonContent(
    *              @OA\Property(
    *                  property="code",
    *                  type="integer",
    *              ),
    *              @OA\Property(
    *                  property="expires_in",
    *                  type="integer",
    *              ),
    *              @OA\Property(
    *                  property="token",
    *                  type="string",
    *              ),
    *              @OA\Property(
    *                  property="token_type",
    *                  type="string",
    *              ),
    *              @OA\Property(
    *                  property="user",
    *                  ref="#/components/schemas/UserWithCampasAndRole",
    *              ),
    *          ),
    *     ),
    *     @OA\Response(
    *         response="500",
    *         description="An error has occurred."
    *     )
    * )
    */

    public function refresh(){
        return $this->responseWithToken(Auth::guard('api')->refresh());
    }
}
