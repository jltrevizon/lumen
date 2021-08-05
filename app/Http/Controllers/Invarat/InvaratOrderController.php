<?php

namespace App\Http\Controllers\Invarat;

use App\Http\Controllers\Controller;
use App\Repositories\Invarat\InvaratWorkshopRepository;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response as HttpFoundationResponse;

class InvaratOrderController extends Controller
{
    public function __construct(InvaratWorkshopRepository $invaratWorkshopRepository)
    {
        $this->invaratWorkshopRepository = $invaratWorkshopRepository;
    }

    public function create(Request $request){
        $workshop = $this->createDataResponse($this->invaratWorkshopRepository->createWorkshop($request->input('workshop')), HttpFoundationResponse::HTTP_CREATED);
        return $workshop;
    }
}
