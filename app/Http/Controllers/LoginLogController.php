<?php

namespace App\Http\Controllers;

use App\Models\LoginLog;
use App\Repositories\LoginLogRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class LoginLogController extends Controller
{

    public function __construct(LoginLogRepository $loginLogRepository)
    {
        $this->loginLogRepository = $loginLogRepository;
    }

    /**
    * @OA\Get(
    *     path="/api/login-logs/getall",
    *     tags={"login-logs"},
    *     summary="Get all login logs",
    *     @OA\Parameter(
    *         name="id",
    *         in="path",
    *         required=true,
    *         @OA\Schema(
    *             type="string"
    *         )
    *     ),
    *     @OA\Response(
    *         response=200,
    *         description="Successful operation",
    *         @OA\JsonContent(ref="#/components/schemas/LoginLog"),
    *    ),
    *     @OA\Response(
    *         response="500",
    *         description="An error has occurred."
    *     )
    * )
    */

    public function getAll(Request $request){
        return $this->getDataResponse($this->loginLogRepository->getAll($request), Response::HTTP_OK);
    }

    public function create(Request $request){
        $loginLog = new LoginLog();
        $loginLog->user_id = Auth::id();
        $loginLog->device_description = $request->input('device_description');
        $loginLog->save();
        return $loginLog;
    }

    public function getUser(Request $request){
        return LoginLog::where('user_id', $request->input('user_id'))
                    ->get();
    }


}
