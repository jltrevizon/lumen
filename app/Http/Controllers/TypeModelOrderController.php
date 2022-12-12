<?php

namespace App\Http\Controllers;

use App\Repositories\TypeModelOrderRepository;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response as HttpFoundationResponse;

class TypeModelOrderController extends Controller
{
    public function __construct(TypeModelOrderRepository $typeModelOrderRepository)
    {
        $this->typeModelOrderRepository = $typeModelOrderRepository;
    }

    /**
    * @OA\Get(
    *     path="/api/type-model-order",
    *     tags={"type-model-orders"},
    *     summary="Get all type type model orders",
    *     security={
    *          {"bearerAuth": {}}
    *     },
    *     @OA\Response(
    *         response=200,
    *         description="Successful operation",
    *         @OA\JsonContent(
    *              @OA\Property(
    *                  property="type_model_orders",
    *                  type="array",
    *                  @OA\Items(ref="#/components/schemas/TypeModelOrder")
    *              ),
    *          ),
    *      ),
    *     @OA\Response(
    *         response="500",
    *         description="An error has occurred."
    *     )
    * )
    */

    public function getAll(){
        return $this->getDataResponse(['type_model_orders' => $this->typeModelOrderRepository->getAll()], HttpFoundationResponse::HTTP_OK);
    }
}
