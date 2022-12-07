<?php

namespace App\Http\Controllers;

use App\Repositories\BudgetLineRepository;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class BudgetLineController extends Controller
{

    public function __construct(BudgetLineRepository $budgetLineRepository)
    {
        $this->budgetLineRepository = $budgetLineRepository;
    }

    /**
    * @OA\Get(
    *     path="/budget-lines",
    *     tags={"budget-lines"},
    *     summary="Get all budget lines",
    *     security={
    *          {"bearerAuth": {}}
    *     },
    *     @OA\Parameter(
    *       name="with[]",
    *       in="query",
    *       description="A list of relatonship",
    *       required=false,
    *       @OA\Schema(
    *           type="array",
    *           example={"relationship1","relationship2"},
    *           @OA\Items(type="string")
    *       )
    *     ),
    *     @OA\Response(
    *         response=200,
    *         description="Successful operation",
    *         value= @OA\JsonContent(
    *           type="array",
    *           @OA\Items(ref="#/components/schemas/BudgetLine")
    *         ),
    *     ),
    *     @OA\Response(
    *         response="500",
    *         description="An error has occurred."
    *     )
    * )
    */

    public function index(Request $request){
        return $this->getDataResponse($this->budgetLineRepository->index($request), Response::HTTP_OK);
    }

}
