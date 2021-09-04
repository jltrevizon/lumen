<?php

namespace App\Http\Controllers;

use App\Repositories\TypeModelOrderRepository;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response as HttpFoundationResponse;

class TypeModelOrderController extends Controller
{
    public function __construct(TypeModelOrderRepository $typeModelOrderRepository)
    {
        $this->typeModelOrderRepository = $typeModelOrderRepository;
    }

    public function getAll(){
        return $this->getDataResponse(['type_model_orders' => $this->typeModelOrderRepository->getAll(), HttpFoundationResponse::HTTP_OK]);
    }
}
