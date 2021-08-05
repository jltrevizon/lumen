<?php

namespace App\Http\Controllers\Invarat;

use App\Http\Controllers\Controller;
use App\Repositories\Invarat\InvaratVehicleRepository;
use App\Repositories\Invarat\InvaratWorkshopRepository;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response as HttpFoundationResponse;

class InvaratOrderController extends Controller
{
    public function __construct(
        InvaratWorkshopRepository $invaratWorkshopRepository,
        InvaratVehicleRepository $invaratVehicleRepository)
    {
        $this->invaratWorkshopRepository = $invaratWorkshopRepository;
        $this->invaratVehicleRepository = $invaratVehicleRepository;
    }

    public function create(Request $request){
        $workshop = $this->genericResponse($this->invaratWorkshopRepository->createWorkshop($request->input('workshop')));
        $vehicle = $this->genericResponse($this->invaratVehicleRepository->createVehicle($request));
        return [
            'user' => $workshop['user'],
            'workshop' => $workshop['workshop'],
            'vehicle' => $vehicle
        ];
    }
}
