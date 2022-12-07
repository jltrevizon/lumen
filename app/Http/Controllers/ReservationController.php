<?php

namespace App\Http\Controllers;

use App\Repositories\ReservationRepository;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response as HttpFoundationResponse;

class ReservationController extends Controller
{
    public function __construct(ReservationRepository $reservationRepository)
    {
        $this->reservationRepository = $reservationRepository;
    }


    /**
     * @OA\Post(
     *     path="/api/get-reservations",
     *     tags={"reservations"},
     *     summary="get reservation active",
     *     security={
     *          {"bearerAuth": {}}
     *     },
     *     operationId="getReservationActive",
     *     @OA\Response(
     *         response="200",
     *         description="Successful operation",
     *         value=@OA\JsonContent(
     *                     @OA\Property(
     *                         property="reservation",
     *                         type="object",
     *                         ref="#/components/schemas/Reservation",
     *                     ),
     *                     @OA\Property(
     *                         property="with[]",
     *                         type="array",
     *                         @OA\Items(type="string"),
     *                     ),
     *          ),
     *     ),
     *     @OA\RequestBody(
     *         description="Reservation",
     *         required=true,
     *         value= @OA\JsonContent(
     *                      @OA\Property(
     *                         property="company_id",
     *                         type="integer",
     *                      ),
     *         ),
     *     ),
     * ),
     */

    public function getReservationActive(Request $request){

        $this->validate($request, [
            'company_id' => 'required|integer'
        ]);

        return $this->getDataResponse($this->reservationRepository->getReservationActive($request), HttpFoundationResponse::HTTP_OK);
    }

    /**
     * @OA\Post(
     *     path="/get-reservations/by-campa",
     *     tags={"reservations"},
     *     summary="get reservation active by campa",
     *     security={
     *          {"bearerAuth": {}}
     *     },
     *     operationId="getReservationActiveByCampa",
     *     @OA\Response(
     *         response="200",
     *         description="Successful operation",
     *         value=@OA\JsonContent(
     *                         type="array",
     *                         @OA\Items(ref="#/components/schemas/Reservation"),
     *          ),
     *     ),
     *     @OA\Response(
     *         response="409",
     *         description="",
     *          value=@OA\JsonContent(
     *                     @OA\Property(
     *                         property="message",
     *                         type="string",
     *                     ),
     *          )
     *      ),
     *     @OA\RequestBody(
     *         description="Reservation",
     *         required=true,
     *         value= @OA\JsonContent(
     *                      @OA\Property(
     *                         property="campa_id",
     *                         type="integer",
     *                      ),
     *         ),
     *     ),
     * ),
     */

    public function getReservationActiveByCampa(Request $request){

        $this->validate($request, [
            'campa_id' => 'required|integer'
        ]);

        return $this->getDataResponse($this->reservationRepository->getReservationActiveByCampa($request), HttpFoundationResponse::HTTP_OK);
    }

    /**
     * @OA\Post(
     *     path="/reservations/update",
     *     tags={"reservations"},
     *     summary="Updatee",
     *     security={
     *          {"bearerAuth": {}}
     *     },
     *     operationId="UpdateReservation",
     *     @OA\Response(
     *         response="200",
     *         description="Successful operation",
     *         value=@OA\JsonContent(ref="#/components/schemas/ReservationWithTransport"),
     *     ),
     *     @OA\RequestBody(
     *         description="Reservation",
     *         required=true,
     *         value= @OA\JsonContent(
     *                      @OA\Property(
     *                         property="reservation_id",
     *                         type="integer",
     *                      ),
     *         ),
     *     ),
     * ),
     */

    public function update(Request $request){
        return $this->updateDataResponse($this->reservationRepository->update($request), HttpFoundationResponse::HTTP_OK);
    }

    /**
     * @OA\Post(
     *     path="/get-reservation/by-vehicle",
     *     tags={"reservations"},
     *     summary="get reservation by vehicle",
     *     security={
     *          {"bearerAuth": {}}
     *     },
     *     operationId="getReservationsByVehicle",
     *     @OA\Response(
     *         response="200",
     *         description="Successful operation",
     *         value=@OA\JsonContent(ref="#/components/schemas/Reservation"),
     *     ),
     *     @OA\RequestBody(
     *         description="Reservation",
     *         required=true,
     *         value= @OA\JsonContent(
     *                      @OA\Property(
     *                         property="vehicle_id",
     *                         type="integer",
     *                      ),
     *         ),
     *     ),
     * ),
     */

    public function getReservationsByVehicle(Request $request){

        $this->validate($request, [
            'vehicle_id' => 'required|integer'
        ]);

        return $this->getDataResponse($this->reservationRepository->getReservationsByVehicle($request), HttpFoundationResponse::HTTP_OK);
    }

    /**
     * @OA\Post(
     *     path="/reservation/without-order",
     *     tags={"reservations"},
     *     summary="vehicle whitout order",
     *     security={
     *          {"bearerAuth": {}}
     *     },
     *     operationId="vehicleWithoutOrder",
     *     @OA\Response(
     *         response="200",
     *         description="Successful operation",
     *         @OA\JsonContent(ref="#/components/schemas/Reservation"),
     *     ),
     *     @OA\RequestBody(
     *         description="Reservation",
     *         required=true,
     *         value=@OA\JsonContent(
     *                     @OA\Property(
     *                         property="vehicle_id",
     *                         type="integer",
     *                     ),
     *                     @OA\Property(
     *                         property="with[]",
     *                         type="array",
     *                         @OA\Items(type="string"),
     *                     )
     *          ),
     *     ),
     * ),
     */

    public function vehicleWithoutOrder(Request $request){

        $this->validate($request, [
            'vehicle_id' => 'required|integer'
        ]);

        return $this->getDataResponse($this->reservationRepository->vehicleWithoutOrder($request), HttpFoundationResponse::HTTP_OK);
    }

    /**
     * @OA\Post(
     *     path="/reservation/without-contract",
     *     tags={"reservations"},
     *     summary="vehicle whitout contract",
     *     security={
     *          {"bearerAuth": {}}
     *     },
     *     operationId="vehicleWithoutContract",
     *     @OA\Response(
     *         response="200",
     *         description="Successful operation",
     *         @OA\JsonContent(ref="#/components/schemas/Reservation"),
     *     ),
     *     @OA\RequestBody(
     *         description="Reservation",
     *         required=true,
     *         value=@OA\JsonContent(
     *                     @OA\Property(
     *                         property="vehicle_id",
     *                         type="integer",
     *                     ),
     *                     @OA\Property(
     *                         property="with[]",
     *                         type="array",
     *                         @OA\Items(type="string"),
     *                     )
     *          ),
     *     ),
     * ),
     */

    public function vehicleWithoutContract(Request $request){

        $this->validate($request, [
            'vehicle_id' => 'required|integer'
        ]);

        return $this->getDataResponse($this->reservationRepository->vehicleWithoutContract($request), HttpFoundationResponse::HTTP_OK);
    }

}
