<?php

namespace App\Http\Controllers;

use App\Mail\DownloadVehicles;
use App\Models\PendingDownload;
use App\Models\SubState;
use App\Models\Vehicle;
use Illuminate\Http\Request;
use App\Repositories\VehicleRepository;
use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\App;
use Symfony\Component\HttpFoundation\Response as HttpFoundationResponse;
use Illuminate\Support\Facades\Auth;
use Symfony\Bridge\PsrHttpMessage\Factory\HttpFoundationFactory;

class VehicleController extends Controller
{

    public function __construct(VehicleRepository $vehicleRepository, DownloadVehicles $downloadVehicles)
    {
        $this->vehicleRepository = $vehicleRepository;
        $this->downloadVehicles = $downloadVehicles;
    }

    public function getVehiclesWithPendingTashDelivered(){
        return Vehicle::whereHas('pendingTasks', function (Builder $builder){
            return $builder->where(function($query) {
                return $query->where('state_pending_task_id','!=', 3)
                ->orWhereNull('state_pending_task_id');
            })
            ->where('approved', true);
        })
        ->where('sub_state_id', SubState::ALQUILADO)
        ->paginate(25);
    }

    public function download(Request $request){
        $pendingDownload = new PendingDownload();
        $pendingDownload->user_id = Auth::id();
        $pendingDownload->type_document = 'vehicles';
        $pendingDownload->save();
        return $this->createDataResponse('Documento generandose, en cuanto esté listo, le llegará a su correo', HttpFoundationResponse::HTTP_OK);
    }

    public function getAll(Request $request){

        return $this->getDataResponse($this->vehicleRepository->getAll($request), HttpFoundationResponse::HTTP_OK);
    }

    public function getById(Request $request, $id){

        return $this->getDataResponse($this->vehicleRepository->getById($request, $id), HttpFoundationResponse::HTTP_OK);
    }

    public function create(Request $request){

        $this->validate($request, [
            'campa_id' => 'required|integer',
            'category_id' => 'required|integer',
            'plate' => 'required|string',
            'vehicle_model_id' => 'nullable|integer',
            'first_plate' => 'nullable|date',
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

    public function deleteMassive(Request $request){
        return $this->deleteDataResponse($this->vehicleRepository->deleteMassive($request), HttpFoundationResponse::HTTP_OK);
    }

    public function createFromExcel(Request $request){

        $this->validate($request, [
            'vehicles' => 'required'
        ]);

        return $this->createDataResponse($this->vehicleRepository->createFromExcel($request), HttpFoundationResponse::HTTP_CREATED);
    }

    public function getVehiclesWithReservationWithoutOrderCampa(Request $request){

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

    public function vehicleTotalsState(Request $request)
    {
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

    public function changeSubState(Request $request){
        return $this->updateDataResponse($this->vehicleRepository->changeSubState($request), HttpFoundationResponse::HTTP_OK);
    }

    public function setVehicleRented(Request $request){
        return $this->updateDataResponse($this->vehicleRepository->setVehicleRented($request), HttpFoundationResponse::HTTP_OK);
    }

    public function setSubStateNull(Request $request){
        return $this->updateDataResponse($this->vehicleRepository->setSubStateNull($request), HttpFoundationResponse::HTTP_OK);
    }
}
