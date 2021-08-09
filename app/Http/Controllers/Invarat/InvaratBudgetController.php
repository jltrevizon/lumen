<?php

namespace App\Http\Controllers\Invarat;

use App\Http\Controllers\Controller;
use App\Repositories\Invarat\InvaratBudgetRepository;
use Illuminate\Http\Request;

class InvaratBudgetController extends Controller
{
    public function __construct(
        InvaratBudgetRepository $invaratBudgetRepository
    )
    {
        $this->invaratBudgetRepository = $invaratBudgetRepository;
    }

    public function create(Request $request){
        return $this->invaratBudgetRepository->create($request);
    }
}
