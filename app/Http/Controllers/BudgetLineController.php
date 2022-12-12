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
    *     path="/api/budget-lines",
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
    *     @OA\Parameter(
    *       name="per_page",
    *       in="query",
    *       description="Items per page",
    *       required=false,
    *       @OA\Schema(
    *           type="integer",
    *           example=5,
    *       )
    *     ),
    *     @OA\Parameter(
    *       name="page",
    *       in="query",
    *       description="Page",
    *       required=false,
    *       @OA\Schema(
    *           type="integer",
    *           example=1,
    *       )
    *     ),
    *     @OA\Response(
    *         response=200,
    *         description="Successful operation",
    *         @OA\JsonContent(ref="#/components/schemas/BudgetLinePaginate")
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
