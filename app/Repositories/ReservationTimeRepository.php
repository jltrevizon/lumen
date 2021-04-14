<?php

namespace App\Repositories;

use App\Models\ReservationTime;

class ReservationTimeRepository {

    public function __construct()
    {

    }

    public function getByCompany($request){
        return ReservationTime::with(['company'])
                            ->where('company_id', $request->json()->get('company_id'))
                            ->first();
    }

    public function create($request){
        $exists_reservation_time = ReservationTime::where('company_id', $request->json()->get('company_id'))
                                                ->first();
        if($exists_reservation_time){
            $reservation_time = new ReservationTime();
            $reservation_time->company_id = $request->json()->get('comapny_id');
            $reservation_time->hours = $request->json()->get('hours');
            $reservation_time->save();
            return $reservation_time;
        }

        return [
            'message' => 'Ya existe un tiempo de reserva para esta empresa'
        ];
    }

    public function update($request){
        $reservation_time = ReservationTime::where('company_id', $request->json()->get('company_id'))
                                        ->first();
        $reservation_time->hours = $request->json()->get('hours');
        $reservation_time->save();
        return $reservation_time;
    }
}
