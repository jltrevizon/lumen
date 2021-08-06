<?php

namespace App\Http\Controllers\Invarat;

use App\Http\Controllers\Controller;
use App\Repositories\Invarat\InvaratOrderRepository;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response as HttpFoundationResponse;

class InvaratOrderController extends Controller
{
    public function __construct(
        InvaratOrderRepository $invaratOrderRepository)
    {
        $this->invaratOrderRepository = $invaratOrderRepository;
    }

    public function create(Request $request){
        return $this->createDataResponse($this->invaratOrderRepository->createOrder($request), HttpFoundationResponse::HTTP_CREATED);
    }
}
