<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\ReceptionRepository;
use Symfony\Component\HttpFoundation\Response as HttpFoundationResponse;

class ReceptionController extends Controller
{
    public function __construct(ReceptionRepository $receptionRepository)
    {
        $this->receptionRepository = $receptionRepository;
    }

    public function index(Request $request){
        return $this->getDataResponse($this->receptionRepository->index($request), HttpFoundationResponse::HTTP_OK);
    }

    public function create(Request $request){

        $this->validate($request, [
            'vehicle_id' => 'required|integer'
        ]);

        return $this->createDataResponse($this->receptionRepository->create($request), HttpFoundationResponse::HTTP_CREATED);
    }

    public function getById($id){
        return $this->getDataResponse($this->receptionRepository->getById($id), HttpFoundationResponse::HTTP_OK);
    }

    public function updateReception(Request $request, $id){  
        return $this->updateDataResponse($this->receptionRepository->updateReception($request, $id), HttpFoundationResponse::HTTP_OK);
    }
}
