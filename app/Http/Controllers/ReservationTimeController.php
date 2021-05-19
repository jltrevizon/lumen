<?php

namespace App\Http\Controllers;

use App\Repositories\ReservationTimeRepository;
use Illuminate\Http\Request;

class ReservationTimeController extends Controller
{
    public function __construct(ReservationTimeRepository $reservationTimeRepository)
    {
        $this->reservationTimeRepository = $reservationTimeRepository;
    }

    public function getByCompany(Request $request){
        return $this->reservationTimeRepository->getByCompany($request);
    }

    public function create(Request $request){
        return $this->reservationTimeRepository->create($request);
    }

    public function update(Request $request){
        return $this->reservationTimeRepository->update($request);
    }
}
