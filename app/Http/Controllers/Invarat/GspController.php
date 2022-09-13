<?php

namespace App\Http\Controllers\Invarat;

use App\Http\Controllers\Controller;
use App\Repositories\Invarat\GspRepository;
use App\Repositories\Invarat\InvaratOrderRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response as HttpFoundationResponse;

class GspController extends Controller
{

    public function __construct(GspRepository $gspRepository)
    {
        $this->gspRepository = $gspRepository;
    }


    public function createVehicle(Request $request){

        return $this->createDataResponse($this->gspRepository->createVehicle($request), HttpFoundationResponse::HTTP_CREATED);
    }

    public function getVehicleForPlate(Request $request){

        return $this->createDataResponse($this->gspRepository->getVehicleForPlate($request), HttpFoundationResponse::HTTP_CREATED);
    }

    public function createBudgeForType(Request $request){

        return $this->createDataResponse($this->gspRepository->createBudgeForType($request), HttpFoundationResponse::HTTP_CREATED);
    }

    public function falloCheckVehicle(Request $request){

        return $this->updateDataResponse($this->gspRepository->falloCheckVehicle($request), HttpFoundationResponse::HTTP_CREATED);
    }

//    public function orderFilter(Request $request){
//        return $this->getDataResponse($this->invaratOrderRepository->orderFilter($request), HttpFoundationResponse::HTTP_OK);
//    }


}
