<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transport;
use App\Repositories\TransportRepository;
use Symfony\Component\HttpFoundation\Response as HttpFoundationResponse;

class TransportController extends Controller
{

    public function __construct(TransportRepository $transportRepository)
    {
        $this->transportRepository = $transportRepository;
    }

    public function getAll(){
        return $this->getDataResponse(Transport::all(), HttpFoundationResponse::HTTP_OK);
    }

    public function getById($id){
        return $this->getDataResponse($this->transportRepository->getById($id), HttpFoundationResponse::HTTP_OK);
    }

    public function create(Request $request){

        $this->validate($request, [
            'name' => 'required|string'
        ]);

        return $this->createDataResponse($this->transportRepository->create($request), HttpFoundationResponse::HTTP_CREATED);
    }

    public function update(Request $request, $id){
        return $this->updateDataResponse($this->transportRepository->update($request, $id), HttpFoundationResponse::HTTP_OK);
    }

    public function delete($id){
        return $this->deleteDataResponse($this->transportRepository->update($id), HttpFoundationResponse::HTTP_OK);
    }
}
