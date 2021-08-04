<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TypeRequest;
use App\Repositories\TransportRepository;
use Symfony\Component\HttpFoundation\Response as HttpFoundationResponse;

class TypeRequestController extends Controller
{

    public function __construct(TransportRepository $transportRepository)
    {
        $this->transportRepository = $transportRepository;
    }

    public function getAll(){
        return $this->getDataResponse(TypeRequest::all(), HttpFoundationResponse::HTTP_OK);
    }

    public function getById($id){
        return $this->getDataResponse($this->transportRepository->getById($id), HttpFoundationResponse::HTTP_OK);
    }

    public function create(Request $request){
        return $this->createDataResponse($this->transportRepository->create($request), HttpFoundationResponse::HTTP_CREATED);
    }

    public function update(Request $request, $id){
        return $this->updateDataResponse($this->transportRepository->update($request), HttpFoundationResponse::HTTP_OK);
    }

    public function delete($id){
        return $this->deleteDataResponse($this->transportRepository->delete($id), HttpFoundationResponse::HTTP_OK);
    }
}
