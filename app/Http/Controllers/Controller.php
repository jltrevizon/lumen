<?php

namespace App\Http\Controllers;

use App\Models\User;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;
use Laravel\Lumen\Routing\Controller as BaseController;
use Symfony\Component\HttpFoundation\Response;

class Controller extends BaseController
{
    protected function responseWithToken($token){
        $user = User::with(['role','campas.company'])
                    ->where('id', Auth::id())
                    ->first();
        return response()->json([
            'token' => $token,
            'token_type' => 'bearer',
            'user' => $user,
            'expires_in' => Auth::factory()->getTTL() * 60,
            'code' => Response::HTTP_OK
        ], Response::HTTP_OK);
    }

    public function getDataResponse($data, $code = Response::HTTP_OK): JsonResponse {
        try {
            return response()->json($data, $code);
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], Response::HTTP_BAD_REQUEST);
        }
    }

    public function createDataResponse($data, $code = Response::HTTP_CREATED): JsonResponse {
        try {
            return response()->json($data, $code);
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], Response::HTTP_BAD_REQUEST);
        }
    }

    public function updateDataResponse($data, $code): JsonResponse {
        try {
            return response()->json($data, $code);
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], Response::HTTP_BAD_REQUEST);
        }
    }

    public function deleteDataResponse($data, $code): JsonResponse {
        try {
            return response()->json($data, $code);
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], Response::HTTP_BAD_REQUEST);
        }
    }

    public function genericResponse($data) {
        try {
            return $data;
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }
}
