<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\ReceptionRepository;
use Symfony\Component\HttpFoundation\Response as HttpFoundationResponse;

class ReceptionController extends Controller
{
    public function __construct(ReceptionRepository $receptionRepository)
    {
        $this->receptionRepository = $receptionRepository;
    }

    public function index(Request $request)
    {
        return $this->getDataResponse($this->receptionRepository->index($request), HttpFoundationResponse::HTTP_OK);
    }

    public function create(Request $request)
    {

        $this->validate($request, [
            'vehicle_id' => 'required|integer'
        ]);
        $data = $this->receptionRepository->create($request);
        return $this->createDataResponse($data, HttpFoundationResponse::HTTP_CREATED);
    }

    /**
    * @OA\Get(
    *     path="/api/reception/{id}",
    *     tags={"receptions"},
    *     summary="Get reception by ID",
    *     @OA\Parameter(
    *         name="id",
    *         in="path",
    *         required=true,
    *         @OA\Schema(
    *             type="string"
    *         )
    *     ),
    *     @OA\Response(
    *         response=200,
    *         description="Successful operation",
    *         @OA\JsonContent(ref="#/components/schemas/Reception"),
    *    ),
    *     @OA\Response(
    *         response="404",
    *         description="Reception not found."
    *     )
    * )
    */

    public function getById($id)
    {
        return $this->getDataResponse($this->receptionRepository->getById($id), HttpFoundationResponse::HTTP_OK);
    }

    /**
     * @OA\Put(
     *     path="reception/{id}",
     *     tags={"receptions"},
     *     summary="Updated reception",
     *     @OA\RequestBody(
     *         description="Updated reception object",
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/Reception")
     *     ),
     *     operationId="updateReception",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="id that to be updated",
     *         required=true,
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(ref="#/components/schemas/Reception"),
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Reception not found"
     *     ),
     * )
     */

    public function updateReception(Request $request, $id)
    {
        return $this->updateDataResponse($this->receptionRepository->updateReception($request, $id), HttpFoundationResponse::HTTP_OK);
    }
}
