<?php

namespace App\Repositories;

use App\Models\ReservationTime;
use Exception;

class ReservationTimeRepository {

    public function __construct()
    {

    }

    public function getByCompany($request){
        return ReservationTime::with(['company'])
                            ->where('company_id', $request->input('company_id'))
                            ->first();
    }

    public function create($request){
        $exists_reservation_time = ReservationTime::where('company_id', $request->input('company_id'))
                                                ->first();
        if(!$exists_reservation_time){
            $reservation_time = new ReservationTime();
            $reservation_time->company_id = $request->input('company_id');
            $reservation_time->hours = $request->input('hours');
            $reservation_time->save();
            return $reservation_time;
        }

        return [
            'message' => 'Ya existe un tiempo de reserva para esta empresa'
        ];
    }

    public function update($request){
        $reservation_time = ReservationTime::where('company_id', $request->input('company_id'))
                                        ->first();
        $reservation_time->hours = $request->input('hours');
        $reservation_time->save();
        return $reservation_time;
    }
}
