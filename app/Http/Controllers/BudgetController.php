<?php

namespace App\Http\Controllers;

use App\Models\Budget;
use App\Repositories\BudgetRepository;
use Illuminate\Http\Request;
use Symfony\Bridge\PsrHttpMessage\Factory\HttpFoundationFactory;
use Symfony\Component\HttpFoundation\Response as HttpFoundationResponse;

class BudgetController extends Controller
{

    public function __construct(BudgetRepository $budgetRepository)
    {
        $this->budgetRepository = $budgetRepository;
    }
    
    public function index(Request $request){
        return $this->getDataResponse($this->budgetRepository->index($request), HttpFoundationResponse::HTTP_OK);
    }

}
