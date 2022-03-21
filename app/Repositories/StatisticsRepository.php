<?php

namespace App\Repositories;

use App\Models\StateChange;
use App\Models\SubState;
use App\Models\TypeModelOrder;
use App\Models\Vehicle;
use DateTime;
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

    public function getAverageSubState($request){
        $stateChanges = StateChange::filter($request->all())
            ->get()
            ->groupBy('sub_state_id');
        $array = [];
        foreach($stateChanges as $key => $changes){
            if($key != ''){
                $subState = SubState::findOrFail($key);
                $total_time = 0;
                foreach($changes as $change){
                    if($change->datetime_finish_sub_state == null){
                        $total_time += $this->diffDateTimes($change->created_at);
                    } else {
                        $total_time += $change->total_time;
                    }
                }
                $object = new stdClass();
                $object->sub_state = $subState->name;
                $object->average = $total_time / count($changes);
                array_push($array, $object);
            }
        }
        return $array;
    }

    public function getAverageTypeModelOrder(){
        $typeModelOrders = Vehicle::select('id','type_model_order_id')
        ->get()
        ->groupBy('type_model_order_id');
        $array = [];
        foreach($typeModelOrders as $key => $vehicles){
            $object = new stdClass();
            if($key == ''){
                $object->type_model_order = 'Sin canal';
            } else {
                $typeModelOrder = TypeModelOrder::findOrFail($key);
                $object->type_model_order = $typeModelOrder->name;
            }
            $object->total = count($vehicles);
            array_push($array, $object);
        }
        return $array;
    }

    private function diffDateTimes($datetime){
        $datetime1 = new DateTime($datetime);
        $diference = date_diff($datetime1, new DateTime());
        $minutes = $diference->days * 24 * 60;
        $minutes += $diference->h * 60;
        $minutes += $diference->i;
        return $minutes;
    }

}
