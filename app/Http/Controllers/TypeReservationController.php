<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TypeReservation;

class TypeReservationController extends Controller
{
    /**
    * @OA\Get(
    *     path="/api/type-reservations/getall",
    *     tags={"type-reservations"},
    *     summary="Get all type type reservations",
    *     security={
    *          {"bearerAuth": {}}
    *     },
    *     @OA\Response(
    *         response=200,
    *         description="Successful operation",
    *         value= @OA\JsonContent(
    *           type="array",
    *           @OA\Items(ref="#/components/schemas/TypeReservation")
    *         ),
    *     ),
    *     @OA\Response(
    *         response="500",
    *         description="An error has occurred.",
    *     ),
    * ),
    */

    public function getAll(){
        return TypeReservation::all();
    }
}
