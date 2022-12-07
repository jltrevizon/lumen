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
    *     security={
    *          {"bearerAuth": {}}
    *     },
    *     @OA\Parameter(
    *       name="with[]",
    *       in="query",
    *       description="A list of relatonship",
    *       required=false,
    *       @OA\Schema(
    *           type="array",
    *           example={"relationship1","relationship2"},
    *           @OA\Items(type="string")
    *       )
    *     ),
    *     @OA\Response(
    *         response=200,
    *         description="Successful operation",
    *         value= @OA\JsonContent(
    *           type="array",
    *           @OA\Items(ref="#/components/schemas/PeopleForReport")
    *         ),
    *     ),
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
