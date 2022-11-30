<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\BrandRepository;
use Symfony\Component\HttpFoundation\Response as HttpFoundationResponse;

class BrandController extends Controller
{
    public function __construct(BrandRepository $brandRepository)
    {
        $this->brandRepository = $brandRepository;
    }

    public function index(Request $request){
        return $this->getDataResponse($this->brandRepository->index($request), HttpFoundationResponse::HTTP_OK);
    }

    public function show(Request $request, $id){
        return $this->getDataResponse($this->brandRepository->show($request, $id), HttpFoundationResponse::HTTP_OK);
    }

    public function store(Request $request){
        return $this->createDataResponse($this->brandRepository->store($request), HttpFoundationResponse::HTTP_OK);
    }

    /**
     * @OA\Put(
     *     path="/brands/{id}",
     *     tags={"brands"},
     *     summary="Updated brand",
     *     @OA\RequestBody(
     *         description="Updated brand object",
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/Brand")
     *     ),
     *     operationId="updateBrand",
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
     *         @OA\JsonContent(ref="#/components/schemas/Brand"),
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Brand not found"
     *     ),
     * )
     */

    public function update(Request $request, $id){
        return $this->updateDataResponse($this->brandRepository->update($request, $id), HttpFoundationResponse::HTTP_OK);
    }
}
