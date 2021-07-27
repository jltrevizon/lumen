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
        return RequestVehicle::all();
    }

    public function getById($id){
        return RequestVehicle::where('id', $id)
                        ->first();
    }

    public function create(Request $request){

        $this->validate($request, [
            'vehicles' => 'required',
        ]);

        return $this->createDataResponse($this->requestRepository->create($request), HttpFoundationResponse::HTTP_CREATED);
    }

    public function update(Request $request, $id){
        return $this->requestRepository->create($request, $id);
    }

    public function vehiclesRequestedDefleet(Request $request){

        $this->validate($request, [
            'campa_id' => 'required|integer'
        ]);

        return $this->requestRepository->vehiclesRequestedDefleet($request);
    }

    public function vehiclesRequestedReserve(Request $request){

        $this->validate($request, [
            'campa_id' => 'required|integer'
        ]);

        return $this->requestRepository->vehiclesRequestedReserve($request);
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

        return $this->requestRepository->getConfirmedRequest($request);
    }

    public function declineRequest(Request $request){

        $this->validate($request, [
            'request_id' => 'required|integer'
        ]);

        return $this->requestRepository->declineRequest($request);
    }

    public function delete($id){
        RequestVehicle::where('id', $id)
                ->delete();
        return [ 'message' => 'Request deleted' ];
    }

    public function getRequestDefleetApp(){
        return $this->requestRepository->getRequestDefleetApp();
    }

    public function getRequestReserveApp(){
        return $this->requestRepository->getRequestReserveApp();
    }
}
