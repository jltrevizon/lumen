<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Repositories\CampaUserRepository;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response as HttpFoundationResponse;

class CampaUserController extends Controller
{

    public function __construct(CampaUserRepository $campaUserRepository)
    {
        $this->campaUserRepository = $campaUserRepository;
    }

    /**
     * @OA\Post(
     *     path="/api/assign-campa",
     *     tags={"users"},
     *     summary="Create campa user",
     *     security={
     *          {"bearerAuth": {}}
     *     },
     *     operationId="createCampaUser",
     *     @OA\Response(
     *         response="201",
     *         description="Successful operation",
     *         @OA\JsonContent(ref="#/components/schemas/CampaUser"),
     *     ),
     *     @OA\RequestBody(
     *         description="Create user object",
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/CampaUser"),
     *     )
     * )
     */

    public function create(Request $request){

        $this->validate($request, [
            'campas' => 'required'
        ]);

        return $this->createDataResponse($this->campaUserRepository->create($request), HttpFoundationResponse::HTTP_CREATED);
    }

    /**
     * @OA\Post(
     *     path="/api/users/delete-campa",
     *     summary="delete campa",
     *     tags={"users"},
     *     operationId="deleteCampaUser",
     *     security={
     *          {"bearerAuth": {}}
     *     },
     *     @OA\Response(
     *         response=200,
     *         description="",
     *         value = @OA\JsonContent(
     *              @OA\Property(
     *                  property="message",
     *                  type="string",
     *                  example="campa deleted",
     *              ),
     *          ),
     *    ),
     *     @OA\RequestBody(
     *         description="",
     *         required=true,
     *         value = @OA\JsonContent(
     *                     @OA\Property(
     *                         property="campas",
     *                         type="string"
     *                     ),
     *                 )
     *     )
     * )
     */

    public function delete(Request $request){
        $this->validate($request, [
            'campas' => 'required'
        ]);

        return $this->deleteDataResponse($this->campaUserRepository->delete($request), HttpFoundationResponse::HTTP_OK);
    }
}
