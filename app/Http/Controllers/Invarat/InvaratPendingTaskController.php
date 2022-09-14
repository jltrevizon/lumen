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

    public function nextPendingTask(Request $request){
        return $this->createDataResponse($this->invaratVehicleRepository->nextPendingTask($request), HttpFoundationResponse::HTTP_CREATED);
    }

    public function finishPendingTask(Request $request){
        return $this->createDataResponse($this->invaratVehicleRepository->finishTask($request), HttpFoundationResponse::HTTP_CREATED);
    }

    public function cancelPendingTask(Request $request){
        return $this->createDataResponse($this->invaratVehicleRepository->cancelTask($request), HttpFoundationResponse::HTTP_CREATED);
    }

    public function addPendingTaskReacondicionamiento(Request $request){
        return $this->createDataResponse($this->invaratVehicleRepository->addPendingTaskReacondicionamiento($request), HttpFoundationResponse::HTTP_CREATED);
    }

    public function updateOrCreateBudgetPengingTaskGtWeb(Request $request){
        return $this->createDataResponse($this->invaratVehicleRepository->updateOrCreateBudgetPengingTaskGtWeb($request), HttpFoundationResponse::HTTP_CREATED);
    }

    public function updatePendingTaskReacondicionamiento(Request $request){
        return $this->updateDataResponse($this->invaratVehicleRepository->updatePendingTaskReacondicionamiento($request), HttpFoundationResponse::HTTP_CREATED);
    }

}
