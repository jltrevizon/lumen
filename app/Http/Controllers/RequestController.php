<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Request as RequestVehicle;
use App\Repositories\RequestRepository;

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
        return $this->requestRepository->create($request);
    }

    public function update(Request $request, $id){
        return $this->requestRepository->create($request, $id);
    }

    public function vehiclesRequestedDefleet(Request $request){
        return $this->requestRepository->vehiclesRequestedDefleet($request);
    }

    public function vehiclesRequestedReserve(Request $request){
        return $this->requestRepository->vehiclesRequestedReserve($request);
    }

    public function confirmedRequest(Request $request){
        return $this->requestRepository->confirmedRequest($request);
    }

    public function getConfirmedRequest(Request $request){
        return $this->requestRepository->getConfirmedRequest($request);
    }

    public function declineRequest(Request $request){
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
