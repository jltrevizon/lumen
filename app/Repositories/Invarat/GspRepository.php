<?php

namespace App\Repositories\Invarat;

use App\Models\Company;
use App\Models\Order;
use App\Models\State;
use App\Models\StatePendingTask;
use App\Models\SubState;
use App\Models\Vehicle;
use App\Repositories\BrandRepository;
use App\Repositories\Repository;
use App\Repositories\StateChangeRepository;
use App\Repositories\VehicleModelRepository;
use App\Repositories\VehicleRepository;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class GspRepository extends Repository {

    public function __construct(
        BrandRepository $brandRepository,
        VehicleModelRepository $vehicleModelRepository,
        VehicleRepository $vehicleRepository)
    {
        $this->brandRepository = $brandRepository;
        $this->vehicleModelRepository = $vehicleModelRepository;
        $this->vehicleRepository = $vehicleRepository;
    }

    /**
     * Se crea un vehículo por petición de GSP20 sin tareas y con estado pendiende te prueba dinamica
     *
     * @param $request
     * @return mixed
     */
    public function createVehicle($request)
    {

        // Comprobamos si existe el vehículo por matrículla
        $vehicleExist = $this->vehicleRepository->getByPlate($request);
        if ($vehicleExist) return $vehicleExist;

        // Buscamos o cremos marca por nombre
        $brand = $this->brandRepository->getByNameFromExcel($request->input('brand'));
        // Buscamos o creamos modelo por nombew
        $vehicleModel = $this->vehicleModelRepository->getByNameFromExcel($brand->id, $request->input('vehicle_model'));

        $vehicle = Vehicle::create($request->all());
        $vehicle->company_id = Company::INVARAT;
        $vehicle->sub_state_id = SubState::PENDING_TEST_DINAMIC_INITIAL;
        $vehicle->vehicle_model_id = $vehicleModel->id;
        $vehicle->first_plate = $request->input('first_plate');
        $vehicle->save();

        return $vehicle;
    }



//    public function orderFilter($request){
//        return Order::with($this->getWiths($request->with))
//                    ->filter($request->all())
//                    ->paginate($request->input('per_page'));
//    }

}
