<?php

namespace App\Http\Controllers;

use App\Repositories\StatisticsRepository;
use Illuminate\Http\Request;

class StatisticsController extends Controller
{
    
    public function __construct(StatisticsRepository $statisticsRepository)
    {
        $this->statisticsRepository = $statisticsRepository;
    }

    public function getStockByState(){
        return $this->statisticsRepository->getStockByState();
    }

    public function getStockByMonth(){
        return $this->statisticsRepository->getStockByMonth();
    }

    public function getAverageSubState(Request $request){
        return $this->statisticsRepository->getAverageSubState($request);
    }

    public function getAverageTypeModelOrder(){
        return $this->statisticsRepository->getAverageTypeModelOrder();   
    }

    public function getAveragePendingTask(){
        return $this->statisticsRepository->getAveragePendingTask();
    }

    public function halfTaskStart(){
        return $this->statisticsRepository->halfTaskStart();
    }

    public function executionTime(){
        return $this->statisticsRepository->executionTime();
    }

    public function averageTimeInSubState(){
        return $this->statisticsRepository->averageTimeInSubState();
    }

    public function timeApproval(){
        return $this->statisticsRepository->timeApproval();
    }

}
