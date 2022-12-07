<?php

namespace App\Http\Controllers;

use App\Repositories\ReservationTimeRepository;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response as HttpFoundationResponse;

class ReservationTimeController extends Controller
{
    public function __construct(ReservationTimeRepository $reservationTimeRepository)
    {
        $this->reservationTimeRepository = $reservationTimeRepository;
    }

    /**
     * @OA\Post(
     *     path="/api/reservation-time",
     *     tags={"reservation-times"},
     *     summary="Get by Company",
     *     security={
     *          {"bearerAuth": {}}
     *     },
     *     operationId="getByCompany",
     *     @OA\Response(
     *         response="201",
     *         description="Successful operation",
     *         @OA\JsonContent(ref="#/components/schemas/ReservationTimeWithCompany")
     *     ),
     *     @OA\RequestBody(
     *         description="Reservation time with company",
     *         required=true,
     *         value= @OA\JsonContent(
     *                      @OA\Property(
     *                         property="company_id",
     *                         type="integer",
     *                      ),
     *         )
     *     )
     * )
     */

    public function getByCompany(Request $request){

        $this->validate($request, [
            'company_id' => 'required|integer'
        ]);

        return $this->getDataResponse($this->reservationTimeRepository->getByCompany($request), HttpFoundationResponse::HTTP_OK);
    }

    /**
     * @OA\Post(
     *     path="/api/reservation-time/create",
     *     tags={"reservation-times"},
     *     summary="Create reservation time",
     *     security={
     *          {"bearerAuth": {}}
     *     },
     *     operationId="createReservationTime",
     *     @OA\Response(
     *         response="201",
     *         description="Successful operation",
     *         @OA\JsonContent(ref="#/components/schemas/ReservationTime"),
     *     ),
     *     @OA\RequestBody(
     *         description="Create reservation time object",
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/ReservationTime"),
     *     )
     * )
     */

    public function create(Request $request){

        $this->validate($request, [
            'company_id' => 'required|integer',
            'hours' => 'required|integer'
        ]);

        return $this->createDataResponse($this->reservationTimeRepository->create($request), HttpFoundationResponse::HTTP_CREATED);
    }

    /**
     * @OA\Put(
     *     path="/api/reservation-time/update",
     *     tags={"reservation-times"},
     *     summary="Update reservation time",
     *     security={
     *          {"bearerAuth": {}}
     *     },
     *     @OA\RequestBody(
     *         description="Update reservation time",
     *         required=true,
     *         value= @OA\JsonContent(
     *                      @OA\Property(
     *                         property="company_id",
     *                         type="integer",
     *                     ),
     *                     @OA\Property(
     *                         property="hours",
     *                         type="string",
     *                         format="date-time"
     *                     ),
     *          ),
     *     ),
     *     operationId="updateReservationTime",
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(ref="#/components/schemas/ReservationTime"),
     *     ),
     * )
     */

    public function update(Request $request){
        return $this->updateDataResponse($this->reservationTimeRepository->update($request), HttpFoundationResponse::HTTP_OK);
    }
}
