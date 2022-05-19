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

    public function index(Request $request){
        return $this->getDataResponse($this->budgetLineRepository->index($request), Response::HTTP_OK);
    }

}
