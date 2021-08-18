<?php

namespace App\Http\Controllers\Invarat;

use App\Http\Controllers\Controller;
use App\Repositories\Invarat\InvaratVehicleRepository;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response as HttpFoundationResponse;

class InvaratVehicleController extends Controller
{
    public function __construct(InvaratVehicleRepository $invaratVehicleRepository)
    {
        $this->invaratVehicleRepository = $invaratVehicleRepository;
    }

    public function createVehicle(Request $request){
        return $this->createDataResponse($this->invaratVehicleRepository->createVehicle($request), HttpFoundationResponse::HTTP_CREATED);
    }
}
