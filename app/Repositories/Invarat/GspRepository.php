<?php

namespace App\Repositories\Invarat;

use App\Models\BudgetPendingTask;
use App\Models\Company;
use App\Models\GroupTask;
use App\Models\Order;
use App\Models\PendingTask;
use App\Models\State;
use App\Models\StateBudgetPendingTask;
use App\Models\StatePendingTask;
use App\Models\SubState;
use App\Models\Task;
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

        Order::create(array(
            "vehicle_id" => $vehicle->id,
            "id_gsp" => $request->input("id_gsp"),
        ));

        return $vehicle;
    }

    /**
     * Buscamos vehículo por matrícula para la compañía 2 por API, sin auth
     *
     * @param $request
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Model|object|null
     */
    public function getVehicleForPlate($request){

        return Vehicle::with($this->getWiths($request->with))
            ->where("company_id", Company::INVARAT)
            ->where("plate", $request->input("plate"))->first();

    }

    /**
     * Creamos las tareas pendientes de prespuestos dependiendo de la division de valoraciones realizadas por GSP20.
     *
     * @param $request
     * @return array|string[]
     */
    public function createBudgeForType($request){

        try {

            // Ultima tarea
            $lastPendingTask = PendingTask::query()->where("vehicle_id",$request->input("vehicle_id"))->latest()->first();

            if(!$lastPendingTask){
                throw new \Exception("Error al generar las tareas pendientes de los prepupuestos --> ".$request->input("vehicle_id"));
            }

            // Orden 3 en negativo para colocar las 3 tareas por el orden (mecanica, ext_int, neumaticos)
            $order = 3;

            foreach ($request->input("ref_docs") as $task_id => $docs){

                $pendingTask = PendingTask::create(array(
                    "vehicle_id" => $lastPendingTask->vehicle_id,
                    "task_id" => $task_id,
                    "state_pending_task_id" => StatePendingTask::PENDING,
                    "group_task_id" => $lastPendingTask->group_task_id,
                    "duration" => 0,
                    "order" => $lastPendingTask->order - $order
                ));

                foreach ($docs as $doc){

                    BudgetPendingTask::create(array(
                        "pending_task_id" => $pendingTask->id,
                        "state_budget_pending_task_id" => StateBudgetPendingTask::PENDING,
                        "url" => $doc["url"]
                    ));

                }

                $order--;

            }

            return [
                "type" => "success",
                "msg" => ""
            ];

        }catch (\Exception $e){

            Log::debug("ERROR --> ". $e->getMessage()." - ".$e->getFile()." - ".$e->getLine());

            return [
                "type" => "error",
                "msg" => $e->getMessage()
            ];

        }

    }


    /**
     * Finalización vehículo
     *
     * @param $request
     * @return mixed
     */
    public function falloCheckVehicle($request)
    {

        try{

            Log::debug("VEHICLE --> ". print_r($request->input("id_gsp"),true));


            $order = Order::query()->where("id_gsp", $request->input("id_gsp"))->first();

            Log::debug("VEHICLE --> ". print_r($order,true));

            $order->vehicle->sub_state_id = SubState::PENDING_BUDGET;

            if(!$order->vehicle->save()){
                throw new \Exception("Error al finalizar el vehículo en FOCUS");
            }

            $lastPendingTask = PendingTask::query()->where("vehicle_id",$order->vehicle_id)->latest()->first();

            // Generamos nueava tarea de prespuesto por si la tiene que modificar.
            PendingTask::create(array(
                "vehicle_id" => $lastPendingTask->vehicle_id,
                "task_id" => 31,
                "state_pending_task_id" => StatePendingTask::PENDING,
                "group_task_id" => $lastPendingTask->group_task_id,
                "duration" => 6,
                "order" => $lastPendingTask->order + 1
            ));

            return [
                "type" => "success",
                "msg" => ""
            ];

        }catch (\Exception $e){
            Log::debug("ERROR --> ". $e->getMessage()." - ".$e->getFile()." - ".$e->getLine());
            return [
                "type" => "error",
                "msg" => $e->getMessage()
            ];

        }

    }


}
