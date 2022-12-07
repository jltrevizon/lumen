<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TradeState;

class TradeStateController extends Controller
{
    /**
    * @OA\Get(
    *     path="/api/trade-states/getall",
    *     tags={"trade-states"},
    *     summary="Get all type trade states",
    *     security={
    *          {"bearerAuth": {}}
    *     },
    *     @OA\Response(
    *         response=200,
    *         description="Successful operation",
    *         value= @OA\JsonContent(
    *           type="array",
    *           @OA\Items(ref="#/components/schemas/TradeState")
    *         ),
    *     ),
    *     @OA\Response(
    *         response="500",
    *         description="An error has occurred."
    *     )
    * )
    */

    public function getAll(){
        return TradeState::all();
    }
}
