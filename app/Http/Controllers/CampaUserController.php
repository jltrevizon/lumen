<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Repositories\CampaUserRepository;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response as HttpFoundationResponse;

class CampaUserController extends Controller
{

    public function __construct(CampaUserRepository $campaUserRepository)
    {
        $this->campaUserRepository = $campaUserRepository;
    }

    public function create(Request $request){

        $this->validate($request, [
            'campas' => 'required'
        ]);

        return $this->createDataResponse($this->campaUserRepository->create($request), HttpFoundationResponse::HTTP_CREATED);
    }

    public function delete(Request $request){
        $this->validate($request, [
            'campas' => 'required'
        ]);

        return $this->deleteDataResponse($this->campaUserRepository->delete($request), HttpFoundationResponse::HTTP_OK);
    }
}
