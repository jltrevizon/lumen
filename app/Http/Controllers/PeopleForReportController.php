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

    /**
    * @OA\Get(
    *     path="/api/people-for-reports/getall",
    *     tags={"people-for-reports"},
    *     summary="Get all people for reports",
    *     @OA\Response(
    *         response=200,
    *         description="Successful operation",
    *         @OA\JsonContent(ref="#/components/schemas/PeopleForReport"),
    *    ),
    *     @OA\Response(
    *         response="500",
    *         description="An error has occurred."
    *     )
    * )
    */

    public function getAll(Request $request){
        return $this->getDataResponse($this->peopleForReportRepository->getAll($request), Response::HTTP_OK);
    }

}
