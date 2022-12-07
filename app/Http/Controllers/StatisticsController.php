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

    /**
     * @OA\Schema(
     *      schema="AverageSubstate",
     *      allOf = {
     *          @OA\Schema(
     *              @OA\Property(
     *                   property="sub_state",
     *                   type="string",
     *              )
     *          ),
     *          @OA\Schema(
     *              @OA\Property(
     *                   property="average",
     *                   type="number",
     *              )
     *          ),
     *      },
     * )
     *
     * @OA\Schema(
     *      schema="AverageTypeModelOrder",
     *      allOf = {
     *          @OA\Schema(
     *              @OA\Property(
     *                   property="name",
     *                   type="string",
     *              )
     *          ),
     *          @OA\Schema(
     *              @OA\Property(
     *                   property="total",
     *                   type="number",
     *              )
     *          ),
     *      },
     * )
     *
     * @OA\Schema(
     *      schema="AveragePendingTask",
     *      allOf = {
     *          @OA\Schema(
     *              @OA\Property(
     *                   property="name",
     *                   type="string",
     *              )
     *          ),
     *          @OA\Schema(
     *              @OA\Property(
     *                   property="total",
     *                   type="number",
     *              )
     *          ),
     *          @OA\Schema(
     *              @OA\Property(
     *                   property="average",
     *                   type="number",
     *              )
     *          ),
     *      },
     * )
     *
     * @OA\Schema(
     *      schema="HalfTaskStart",
     *      allOf = {
     *          @OA\Schema(
     *              @OA\Property(
     *                   property="name",
     *                   type="string",
     *              )
     *          ),
     *          @OA\Schema(
     *              @OA\Property(
     *                   property="duration",
     *                   type="number",
     *              )
     *          ),
     *      },
     * )
     *
     * @OA\Schema(
     *      schema="TimeApproval",
     *      allOf = {
     *          @OA\Schema(
     *              @OA\Property(
     *                   property="month",
     *                   type="string",
     *              )
     *          ),
     *          @OA\Schema(
     *              @OA\Property(
     *                   property="year",
     *                   type="string",
     *              )
     *          ),
     *          @OA\Schema(
     *              @OA\Property(
     *                   property="total",
     *                   type="number",
     *              )
     *          ),
     *          @OA\Schema(
     *              @OA\Property(
     *                   property="average",
     *                   type="number",
     *              )
     *          ),
     *      },
     * )
     */

    /**
    * @OA\Get(
    *     path="/api/statistics/stock-by-state",
    *     tags={"statistics"},
    *     summary="Get stock by state",
    *     security={
    *          {"bearerAuth": {}}
    *     },
    *     @OA\Response(
    *         response=200,
    *         description="Successful operation",
    *         value= @OA\JsonContent(
    *           @OA\Property(
    *                  property="state",
    *                  type="string",
    *            ),
    *            @OA\Property(
    *                  property="sub_state",
    *                  type="string",
    *            ),
    *            @OA\Property(
    *                  property="total",
    *                  type="number",
    *            ),
    *       )
    *     ),
    *     @OA\Response(
    *         response="500",
    *         description="An error has occurred."
    *     )
    * )
    */

    public function getStockByState(){
        return $this->statisticsRepository->getStockByState();
    }

    /**
    * @OA\Get(
    *     path="/api/statistics/stock-by-month",
    *     tags={"statistics"},
    *     summary="Get stock by month",
    *     security={
    *          {"bearerAuth": {}}
    *     },
    *     @OA\Response(
    *         response=200,
    *         description="Successful operation",
    *         value= @OA\JsonContent(
    *           type="array",
    *           @OA\Items(ref="#/components/schemas/Vehicle")
    *         ),
    *     ),
    *     @OA\Response(
    *         response="500",
    *         description="An error has occurred."
    *     )
    * )
    */

    public function getStockByMonth(){
        return $this->statisticsRepository->getStockByMonth();
    }

    /**
    * @OA\Get(
    *     path="/api/statistics/average-by-substate",
    *     tags={"statistics"},
    *     summary="Get average by substate",
    *     security={
    *          {"bearerAuth": {}}
    *     },
    *     @OA\Response(
    *         response=200,
    *         description="Successful operation",
    *         value= @OA\JsonContent(
    *           type="array",
    *           @OA\Items(ref="#/components/schemas/AverageSubstate")
    *         ),
    *     ),
    *     @OA\Response(
    *         response="500",
    *         description="An error has occurred."
    *     )
    * )
    */

    public function getAverageSubState(Request $request){
        return $this->statisticsRepository->getAverageSubState($request);
    }

    /**
    * @OA\Get(
    *     path="/api/statistics/stock-by-channel",
    *     tags={"statistics"},
    *     summary="Get average by type model order",
    *     security={
    *          {"bearerAuth": {}}
    *     },
    *     @OA\Response(
    *         response=200,
    *         description="Successful operation",
    *         value= @OA\JsonContent(
    *           type="array",
    *           @OA\Items(ref="#/components/schemas/AverageTypeModelOrder")
    *         ),
    *     ),
    *     @OA\Response(
    *         response="500",
    *         description="An error has occurred."
    *     )
    * )
    */

    public function getAverageTypeModelOrder(){
        return $this->statisticsRepository->getAverageTypeModelOrder();
    }

    /**
    * @OA\Get(
    *     path="/api/statistics/average-by-task",
    *     tags={"statistics"},
    *     summary="Get average by task",
    *     security={
    *          {"bearerAuth": {}}
    *     },
    *     @OA\Response(
    *         response=200,
    *         description="Successful operation",
    *         value= @OA\JsonContent(
    *           type="array",
    *           @OA\Items(ref="#/components/schemas/AveragePendingTask")
    *         ),
    *     ),
    *     @OA\Response(
    *         response="500",
    *         description="An error has occurred."
    *     )
    * )
    */

    public function getAveragePendingTask(){
        return $this->statisticsRepository->getAveragePendingTask();
    }

    /**
    * @OA\Get(
    *     path="/api/statistics/half-task-start",
    *     tags={"statistics"},
    *     summary="Get half task start",
    *     security={
    *          {"bearerAuth": {}}
    *     },
    *     @OA\Response(
    *         response=200,
    *         description="Successful operation",
    *         value= @OA\JsonContent(
    *           type="array",
    *           @OA\Items(ref="#/components/schemas/HalfTaskStart")
    *         ),
    *     ),
    *     @OA\Response(
    *         response="500",
    *         description="An error has occurred."
    *     )
    * )
    */

    public function halfTaskStart(){
        return $this->statisticsRepository->halfTaskStart();
    }

    /**
    * @OA\Get(
    *     path="/api/statistics/execution-time",
    *     tags={"statistics"},
    *     summary="Get execution time",
    *     security={
    *          {"bearerAuth": {}}
    *     },
    *     @OA\Response(
    *         response=200,
    *         description="Successful operation",
    *         value= @OA\JsonContent(
    *           type="array",
    *           @OA\Items(ref="#/components/schemas/HalfTaskStart")
    *         ),
    *     ),
    *     @OA\Response(
    *         response="500",
    *         description="An error has occurred."
    *     )
    * )
    */

    public function executionTime(){
        return $this->statisticsRepository->executionTime();
    }

    /**
    * @OA\Get(
    *     path="/api/statistics/average-time-sub-state",
    *     tags={"statistics"},
    *     summary="Get average time sub state",
    *     security={
    *          {"bearerAuth": {}}
    *     },
    *     @OA\Response(
    *         response=200,
    *         description="Successful operation",
    *         value= @OA\JsonContent(
    *           type="array",
    *           @OA\Items(ref="#/components/schemas/StateChange")
    *         ),
    *     ),
    *     @OA\Response(
    *         response="500",
    *         description="An error has occurred."
    *     )
    * )
    */

    public function averageTimeInSubState(){
        return $this->statisticsRepository->averageTimeInSubState();
    }

    /**
    * @OA\Get(
    *     path="/api/statistics/time-approval",
    *     tags={"statistics"},
    *     summary="Get time approval",
    *     security={
    *          {"bearerAuth": {}}
    *     },
    *     @OA\Response(
    *         response=200,
    *         description="Successful operation",
    *         value= @OA\JsonContent(
    *           type="array",
    *           @OA\Items(ref="#/components/schemas/TimeApproval")
    *         ),
    *     ),
    *     @OA\Response(
    *         response="500",
    *         description="An error has occurred."
    *     )
    * )
    */

    public function timeApproval(){
        return $this->statisticsRepository->timeApproval();
    }

}
