<?php

namespace App\Http\Controllers;

use App\Repositories\ReservationTimeRepository;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response as HttpFoundationResponse;

class ReservationTimeController extends Controller
{
    public function __construct(ReservationTimeRepository $reservationTimeRepository)
    {
        $this->reservationTimeRepository = $reservationTimeRepository;
    }

    public function getByCompany(Request $request){

        $this->validate($request, [
            'company_id' => 'required|integer'
        ]);

        return $this->getDataResponse($this->reservationTimeRepository->getByCompany($request), HttpFoundationResponse::HTTP_OK);
    }

    public function create(Request $request){

        $this->validate($request, [
            'company_id' => 'required|integer',
            'hours' => 'required|integer'
        ]);

        return $this->createDataResponse($this->reservationTimeRepository->create($request), HttpFoundationResponse::HTTP_CREATED);
    }

    public function update(Request $request){
        return $this->updateDataResponse($this->reservationTimeRepository->update($request), HttpFoundationResponse::HTTP_OK);
    }
}
