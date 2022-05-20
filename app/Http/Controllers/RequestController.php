<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Request as RequestVehicle;
use App\Repositories\RequestRepository;
use Symfony\Component\HttpFoundation\Response as HttpFoundationResponse;

class RequestController extends Controller
{
    public function __construct(RequestRepository $requestRepository)
    {
        $this->requestRepository = $requestRepository;
    }

    public function getAll(){
        return $this->getDataResponse(RequestVehicle::all(), HttpFoundationResponse::HTTP_OK);
    }

    public function getById($id){
        return $this->getDataResponse(RequestVehicle::findOrFail($id), HttpFoundationResponse::HTTP_OK);
    }

    public function delete($id){
        RequestVehicle::where('id', $id)
                ->delete();
        return [ 'message' => 'Request deleted' ];
    }
}
