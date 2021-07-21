<?php

namespace App\Http\Controllers;

use App\Models\Campa;
use App\Models\DefleetVariable;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\Vehicle;
use App\Repositories\VehicleRepository;
use DateTime;
use Exception;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

class VehicleController extends Controller
{

    public function __construct(VehicleRepository $vehicleRepository)
    {
        $this->vehicleRepository = $vehicleRepository;
    }

    public function getAll(){
        try {
            $user = User::findOrFail(Auth::id());
            $campas = Campa::where('company_id', $user->company_id)
                            ->get();
            //return $campas->pluck('id')->toArray();
            return Vehicle::with(['campa','vehicleModel.brand'])
                        ->whereIn('campa_id', $campas->pluck('id')->toArray())
                        ->paginate(5000);
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], 409);
        }
    }

    public function getById($id){
        return $this->vehicleRepository->getById($id);
    }

    public function create(Request $request){

        $this->validate($request, [
            'campa_id' => 'required|integer',
            'category_id' => 'required|integer',
            'plate' => 'required|string',
            'vehicle_model_id' => 'required|integer',
            'first_plate' => 'required|date',
        ]);

        return $this->vehicleRepository->create($request);
    }

    public function update(Request $request, $id){
        return $this->vehicleRepository->update($request, $id);
    }

    public function verifyPlate(Request $request){

        $this->validate($request, [
            'plate' => 'required|string',
        ]);

        return $this->vehicleRepository->verifyPlate($request);
    }

    public function vehicleDefleet(Request $request){

        $this->validate($request, [
            'campas' => 'required',
            'limit' => 'required|integer'
        ]);

        return $this->vehicleRepository->vehicleDefleet($request);
    }

    public function delete($id){
        return $this->vehicleRepository->delete($id);
    }

    public function createFromExcel(Request $request){

        $this->validate($request, [
            'vehicles' => 'required'
        ]);

        return $this->vehicleRepository->createFromExcel($request);
    }

    public function getVehiclesReadyToDeliveryCampa(Request $request){

        $this->validate($request, [
            'campa_id' => 'required|integer'
        ]);

        return $this->vehicleRepository->getVehiclesReadyToDeliveryCampa($request);
    }

    public function getVehiclesReadyToDeliveryCompany(Request $request){

        $this->validate($request, [
            'company_id' => 'required|integer'
        ]);

        return $this->vehicleRepository->getVehiclesReadyToDeliveryCompany($request);
    }

    public function getVehiclesWithReservationWithoutOrderCampa(Request $request){

        $this->validate($request, [
            'campas' => 'required'
        ]);

        return $this->vehicleRepository->getVehiclesWithReservationWithoutOrderCampa($request);
    }

    public function getVehiclesWithReservationWithoutContractCampa(Request $request){

        $this->validate($request, [
            'campas' => 'required'
        ]);

        return $this->vehicleRepository->getVehiclesWithReservatiopcanWithoutContractCampa($request);
    }

    public function filterVehicle(Request $request){

        return $this->vehicleRepository->filterVehicle($request);
    }

    public function vehicleReserved(){
        return $this->vehicleRepository->vehicleReserved();
    }

    public function vehicleTotalsState(Request $request){

        $this->validate($request, [
            'campas' => 'required'
        ]);

        return $this->vehicleRepository->vehicleTotalsState($request);
    }

    public function vehicleRequestDefleet(){
        return $this->vehicleRepository->vehicleRequestDefleet();
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

        return $this->vehicleRepository->vehiclesByState($request);
    }
}
