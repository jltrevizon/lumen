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

}
