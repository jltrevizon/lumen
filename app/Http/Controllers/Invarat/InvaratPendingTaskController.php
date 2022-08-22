<?php

namespace App\Http\Controllers\Invarat;

use App\Http\Controllers\Controller;
use App\Repositories\Invarat\InvaratPendingTaskRepository;
use App\Repositories\Invarat\InvaratVehicleRepository;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response as HttpFoundationResponse;

class InvaratPendingTaskController extends Controller
{

    public function __construct(InvaratPendingTaskRepository $invaratVehicleRepository)
    {
        $this->invaratVehicleRepository = $invaratVehicleRepository;
    }

    public function startPendingTask(Request $request){
        return $this->createDataResponse($this->invaratVehicleRepository->startTask($request), HttpFoundationResponse::HTTP_CREATED);
    }

    public function cancelPendingTask(Request $request){
        return $this->createDataResponse($this->invaratVehicleRepository->cancelTask($request), HttpFoundationResponse::HTTP_CREATED);
    }

}
