<?php

namespace App\Http\Controllers;

use App\Exports\VehiclesExport;
use Illuminate\Http\Request;
use App\Repositories\VehicleRepository;
use Maatwebsite\Excel\Facades\Excel;
use Symfony\Component\HttpFoundation\Response as HttpFoundationResponse;

class VehicleController extends Controller
{

    public function __construct(VehicleRepository $vehicleRepository)
    {
        $this->vehicleRepository = $vehicleRepository;
    }

    public function download(Request $request, $companyId){
        return Excel::download(new VehiclesExport($companyId), 'vehicles.xlsx');
    }

    public function getAll(Request $request){

        return $this->getDataResponse($this->vehicleRepository->getAll($request), HttpFoundationResponse::HTTP_OK);
    }

    public function getById(Request $request, $id){

        return $this->getDataResponse($this->vehicleRepository->getById($id), HttpFoundationResponse::HTTP_OK);
    }

    public function create(Request $request){

        $this->validate($request, [
            'campa_id' => 'required|integer',
            'category_id' => 'required|integer',
            'plate' => 'required|string',
            'vehicle_model_id' => 'required|integer',
            'first_plate' => 'required|date',
        ]);

        return $this->createDataResponse(['vehicle' => $this->vehicleRepository->create($request)], HttpFoundationResponse::HTTP_CREATED);
    }

    public function update(Request $request, $id){
        return $this->updateDataResponse(['vehicle' => $this->vehicleRepository->update($request, $id)], HttpFoundationResponse::HTTP_OK);
    }

    public function verifyPlate(Request $request){

        $this->validate($request, [
            'plate' => 'required|string',
        ]);

        return $this->getDataResponse($this->vehicleRepository->verifyPlate($request), HttpFoundationResponse::HTTP_OK);
    }

    public function vehicleDefleet(Request $request){

        return $this->getDataResponse(['vehicles' => $this->vehicleRepository->vehicleDefleet($request)], HttpFoundationResponse::HTTP_OK);
    }

    public function delete($id){

        return $this->deleteDataResponse($this->vehicleRepository->delete($id), HttpFoundationResponse::HTTP_OK);
    }

    public function createFromExcel(Request $request){

        $this->validate($request, [
            'vehicles' => 'required'
        ]);

        return $this->createDataResponse($this->vehicleRepository->createFromExcel($request), HttpFoundationResponse::HTTP_CREATED);
    }

    public function getVehiclesWithReservationWithoutOrderCampa(Request $request){

        $this->validate($request, [
            'campas' => 'required'
        ]);

        return $this->getDataResponse($this->vehicleRepository->getVehiclesWithReservationWithoutOrderCampa($request), HttpFoundationResponse::HTTP_OK);
    }

    public function getVehiclesWithReservationWithoutContractCampa(Request $request){

        $this->validate($request, [
            'campas' => 'required'
        ]);

        return $this->getDataResponse($this->vehicleRepository->getVehiclesWithReservationWithoutContractCampa($request), HttpFoundationResponse::HTTP_OK);
    }

    public function filterVehicle(Request $request){
        return $this->getDataResponse($this->vehicleRepository->filterVehicle($request), HttpFoundationResponse::HTTP_OK);
    }

    public function vehicleReserved(Request $request){
        return $this->getDataResponse($this->vehicleRepository->vehicleReserved($request), HttpFoundationResponse::HTTP_OK);
    }

    public function vehicleTotalsState(Request $request){

        $this->validate($request, [
            'campas' => 'required'
        ]);

        return $this->getDataResponse($this->vehicleRepository->vehicleTotalsState($request), HttpFoundationResponse::HTTP_OK);
    }

    public function vehicleRequestDefleet(Request $request){
        return $this->getDataResponse($this->vehicleRepository->vehicleRequestDefleet($request), HttpFoundationResponse::HTTP_OK);
    }

    public function verifyPlateReception(Request $request){

        $this->validate($request, [
            'plate' => 'required|string',
        ]);

        return $this->vehicleRepository->verifyPlateReception($request);
    }
    public function unapprovedTask(){
        return $this->vehicleRepository->unapprovedTask();
    }

    public function vehicleByState(Request $request){

        $this->validate($request, [
            'states' => 'required',
            'date_start' => 'required|date',
            'date_end' => 'required|date',
            'campas' => 'required'
        ]);

        return $this->getDataResponse($this->vehicleRepository->vehiclesByState($request), HttpFoundationResponse::HTTP_OK);
    }
}
