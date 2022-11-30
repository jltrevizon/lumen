<?php

namespace App\Http\Controllers;

use App\Models\PasswordResetCode;
use App\Repositories\PasswordResetCodeRepository;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class PasswordResetCodeController extends Controller
{

    public function __construct(PasswordResetCodeRepository $passwordResetCodeRepository)
    {
        $this->passwordResetCodeRepository = $passwordResetCodeRepository;
    }


    /**
    * @OA\Get(
    *     path="/api/password-reset-codes/getall",
    *     tags={"password-reset-codes"},
    *     summary="Get all password reset codes",
    *     @OA\Response(
    *         response=200,
    *         description="Successful operation",
    *         @OA\JsonContent(ref="#/components/schemas/PasswordResetCode"),
    *    ),
    *     @OA\Response(
    *         response="500",
    *         description="An error has occurred."
    *     )
    * )
    */

    public function getAll(Request $request){
        return $this->getDataResponse($this->passwordResetCodeRepository->getAll($request), Response::HTTP_OK);
    }


}
