<?php

namespace App\Http\Controllers;

use App\Repositories\TypeDeliveryNoteRepository;
use Illuminate\Http\Request;

class TypeDeliveryNoteController extends Controller
{
    public function __construct(TypeDeliveryNoteRepository $typeDeliveryNoteRepository)
    {
        $this->typeDeliveryNoteRepository = $typeDeliveryNoteRepository;
    }

    /**
    * @OA\Get(
    *     path="/api/type-delivery-note",
    *     tags={"type-delivery-note"},
    *     summary="Get all type delivery notes",
    *     security={
    *          {"bearerAuth": {}}
    *     },
    *     @OA\Response(
    *         response=200,
    *         description="Successful operation",
    *         value= @OA\JsonContent(
    *           type="array",
    *           @OA\Items(ref="#/components/schemas/TypeDeliveryNote")
    *         ),
    *     ),
    *     @OA\Response(
    *         response="500",
    *         description="An error has occurred."
    *     )
    * )
    */

    public function index(){
        return $this->getDataResponse($this->typeDeliveryNoteRepository->index());
    }
}
