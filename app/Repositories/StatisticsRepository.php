<?php

namespace App\Repositories;

use App\Models\StatusDamage;
use App\Models\SubState;
use App\Models\Vehicle;
use Illuminate\Support\Facades\DB;
use stdClass;

class StatisticsRepository extends Repository {

    public function getStockByState(){
        $data = [];
        $subStates = Vehicle::selectRaw('sub_state_id, count(*) as total')
            ->whereNotNull('sub_state_id')
            ->groupBy('sub_state_id')
            ->pluck('total','sub_state_id')
            ->all();
        foreach($subStates as $index => $total){
            $subStateComplete = SubState::with(['state'])->findOrFail($index);
            $line = new stdClass();
            $line->state = $subStateComplete->state->name;
            $line->subState = $subStateComplete->name;
            $line->total = $total;
            array_push($data, $line);
        }
        return $data;
    }

    public function getStockByMonth(){
            $vehicles = Vehicle::withTrashed()
            ->select(
                DB::raw('count(id) as `total`'), 
                DB::raw('count(deleted_at) as `deleted`'),
                DB::raw("DATE_FORMAT(created_at, '%m-%Y') date"),  
                DB::raw('YEAR(created_at) year, MONTH(created_at) month')
            )
            ->groupBy('year','month')
            ->get();
        return $vehicles;
    }

}
