<?php

namespace App\Http\Controllers\Invarat;

use App\Http\Controllers\Controller;
use App\Repositories\Invarat\InvaratBudgetRepository;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response as HttpFoundationResponse;

class InvaratBudgetController extends Controller
{
    public function __construct(
        InvaratBudgetRepository $invaratBudgetRepository
    )
    {
        $this->invaratBudgetRepository = $invaratBudgetRepository;
    }

    public function create(Request $request){
        return $this->createDataResponse($this->invaratBudgetRepository->create($request), HttpFoundationResponse::HTTP_CREATED);
    }

    public function update(Request $request){
        return $this->updateDataResponse($this->invaratBudgetRepository->update($request), HttpFoundationResponse::HTTP_OK);
    }
}
