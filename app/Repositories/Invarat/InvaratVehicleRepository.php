<?php

namespace App\Repositories\Invarat;

use App\Models\Company;
use App\Models\StatePendingTask;
use App\Models\SubState;
use App\Models\TypeModelOrder;
use App\Models\Vehicle;
use App\Repositories\BrandRepository;
use App\Repositories\Repository;
use App\Repositories\VehicleModelRepository;
use App\Repositories\VehicleRepository;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Log;

class InvaratVehicleRepository extends Repository {

    public function __construct(
        BrandRepository $brandRepository,
        VehicleModelRepository $vehicleModelRepository,
        VehicleRepository $vehicleRepository
        )
    {
        $this->brandRepository = $brandRepository;
        $this->vehicleModelRepository = $vehicleModelRepository;
        $this->vehicleRepository = $vehicleRepository;
    }

    public function createVehicle($request){
        $vehicleExist = $this->vehicleRepository->getByPlate($request);
        if($vehicleExist) return $vehicleExist;
        $brand = $this->brandRepository->getByNameFromExcel($request->input('brand'));
        $vehicleModel = $this->vehicleModelRepository->getByNameFromExcel($brand->id, $request->input('vehicle_model'));
        $vehicle = Vehicle::create($request->all());
        $vehicle->company_id = Company::INVARAT;
        $vehicle->sub_state_id = SubState::PENDING_TEST_DINAMIC_INITIAL;
        $vehicle->vehicle_model_id= $vehicleModel->id;
        $vehicle->save();
        return $vehicle;
    }

    /**
     * Obtenemos vehículos de la compañía 2
     *
     * @param $request
     * @return array
     */
    public function filterVehicle($request){

        $query = Vehicle::with($this->getWiths($request->with))
            ->filter($request->all())
            ->where('company_id',2)
            ->paginate($request->input('per_page') ?? 10);

        return ['vehicles' => $query];

    }

    public function vehiclesByChannel($request){
        return Vehicle::with($this->getWiths($request->with))
            ->whereHas('pendingTasks', function(Builder $builder) {
                return $builder->where('state_pending_task_id','!=' , StatePendingTask::FINISHED);
            })
            ->where('type_model_order_id', '!=', TypeModelOrder::ALDFLEX)
            ->get()
            ->groupby('type_model_order_id');
    }

}
