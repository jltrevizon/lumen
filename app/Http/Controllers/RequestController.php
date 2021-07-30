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

    public function create(Request $request){

        $this->validate($request, [
            'vehicles' => 'required',
        ]);

        return $this->createDataResponse($this->requestRepository->create($request), HttpFoundationResponse::HTTP_CREATED);
    }

    public function update(Request $request, $id){
        return $this->updateDataResponse($this->requestRepository->create($request, $id), HttpFoundationResponse::HTTP_OK);
    }

    public function vehiclesRequestedDefleet(Request $request){

        $this->validate($request, [
            'campa_id' => 'required|integer'
        ]);

        return $this->getDataResponse($this->requestRepository->vehiclesRequestedDefleet($request), HttpFoundationResponse::HTTP_OK);
    }

    public function vehiclesRequestedReserve(Request $request){

        $this->validate($request, [
            'campa_id' => 'required|integer'
        ]);

        return $this->getDataResponse($this->requestRepository->vehiclesRequestedReserve($request), HttpFoundationResponse::HTTP_OK);
    }

    public function confirmedRequest(Request $request){

        $this->validate($request, [
            'request_id' => 'required|integer'
        ]);

        return $this->createDataResponse($this->requestRepository->confirmedRequest($request), HttpFoundationResponse::HTTP_CREATED);
    }

    public function getConfirmedRequest(Request $request){

        $this->validate($request, [
            'type_request_id' => 'required|integer',
            'campa_id' => 'required|integer'
        ]);

        return $this->getDataResponse($this->requestRepository->getConfirmedRequest($request), HttpFoundationResponse::HTTP_OK);
    }

    public function declineRequest(Request $request){

        $this->validate($request, [
            'request_id' => 'required|integer'
        ]);

        return $this->updateDataResponse($this->requestRepository->declineRequest($request), HttpFoundationResponse::HTTP_OK);
    }

    public function delete($id){
        RequestVehicle::where('id', $id)
                ->delete();
        return [ 'message' => 'Request deleted' ];
    }

    public function getRequestDefleetApp(Request $request){
        return $this->getDataResponse($this->requestRepository->getRequestDefleetApp($request), HttpFoundationResponse::HTTP_OK);
    }

    public function getRequestReserveApp(Request $request){
        return $this->getDataResponse($this->requestRepository->getRequestReserveApp(), HttpFoundationResponse::HTTP_OK);
    }
}
