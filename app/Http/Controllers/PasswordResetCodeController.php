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


    public function getAll(Request $request){
        return $this->getDataResponse($this->passwordResetCodeRepository->getAll($request), Response::HTTP_OK);
    }


}
