<?php

namespace App\Http\Controllers;

use App\Models\User;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;
use Laravel\Lumen\Routing\Controller as BaseController;
use Symfony\Component\HttpFoundation\Response;

/**
* @OA\Info(title="API Focus", version="1.0")
*
* @OA\Server(url=SWAGGER_API_HOST_LOCAL)
* @OA\Server(url=SWAGGER_API_HOST_DEV)
* @OA\Server(url=SWAGGER_API_HOST_PROD)
*
* @OA\SecurityScheme(
*      securityScheme="bearerAuth",
*      type="http",
*      scheme="bearer",
*      bearerFormat="JWT",
* )
*/


class Controller extends BaseController
{
    protected function responseWithToken($token){
        $user = User::with(['role','campas.company', 'campas.campaTypeModelOrders.typeModelOrder'])
                    ->where('id', Auth::id())
                    ->first();
        return response()->json([
            'token' => $token,
            'token_type' => 'bearer',
            'user' => $user,
            'expires_in' => null,
            'code' => Response::HTTP_OK
        ], Response::HTTP_OK);
    }

    /**
     * @OA\Schema(
     *      schema="Links",
     *      @OA\Property(
     *          property="active",
     *          type="boolean",
     *      ),
     *      @OA\Property(
     *          property="label",
     *          type="string",
     *      ),
     *      @OA\Property(
     *          property="url",
     *          type="string",
     *      ),
     * ),
     *
     * @OA\Schema(
     *      schema="Paginate",
     *      @OA\Property(
     *          property="current_page",
     *          type="integer",
     *      ),
     *      @OA\Property(
     *          property="first_page_url",
     *          type="string",
     *      ),
     *      @OA\Property(
     *          property="from",
     *          type="integer",
     *      ),
     *      @OA\Property(
     *          property="last_page",
     *          type="integer",
     *      ),
     *      @OA\Property(
     *          property="last_page_url",
     *          type="string",
     *      ),
     *      @OA\Property(
     *          property="links",
     *          type="array",
     *          @OA\Items(ref="#/components/schemas/Links")
     *      ),
     *      @OA\Property(
     *          property="next_page_url",
     *          type="string",
     *      ),
     *      @OA\Property(
     *          property="path",
     *          type="string",
     *      ),
     *      @OA\Property(
     *          property="per_page",
     *          type="string",
     *      ),
     *      @OA\Property(
     *          property="per_page_url",
     *          type="string",
     *      ),
     *      @OA\Property(
     *          property="to",
     *          type="integer",
     *      ),
     *      @OA\Property(
     *          property="total",
     *          type="integer",
     *      ),
     * ),
     *
     */
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

    public function failResponse($data, $code): JsonResponse
    {
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

    public function getWiths($elements){
        return collect($elements ?? [])->toArray();
    }
}
