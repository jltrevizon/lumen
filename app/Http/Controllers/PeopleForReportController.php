<?php

namespace App\Http\Controllers;

use App\Models\PeopleForReport;
use App\Repositories\PeopleForReportRepository;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class PeopleForReportController extends Controller
{
    
    public function __construct(PeopleForReportRepository $peopleForReportRepository)
    {
        $this->peopleForReportRepository = $peopleForReportRepository;
    }

    public function getAll(Request $request){
        return $this->getDataResponse($this->peopleForReportRepository->getAll($request), Response::HTTP_OK);
    }

}
