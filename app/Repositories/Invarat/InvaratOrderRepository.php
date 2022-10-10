<?php

namespace App\Repositories\Invarat;

use App\Models\Order;
use App\Models\State;
use App\Models\Vehicle;
use App\Repositories\Repository;
use App\Repositories\StateChangeRepository;
use Illuminate\Support\Facades\DB;

class InvaratOrderRepository extends Repository {

    public function __construct(
        InvaratWorkshopRepository $invaratWorkshopRepository,
        InvaratVehicleRepository $invaratVehicleRepository,
        InvaratPendingTaskRepository $invaratPendingTaskRepository,
        StateChangeRepository $stateChangeRepository,
    )
    {
        $this->invaratWorkshopRepository = $invaratWorkshopRepository;
        $this->invaratVehicleRepository = $invaratVehicleRepository;
        $this->invaratPendingTaskRepository = $invaratPendingTaskRepository;
        $this->stateChangeRepository = $stateChangeRepository;
    }

    public function createOrder($request){

//        $workshop = $this->invaratWorkshopRepository->createWorkshop($request->input('workshop'));
//        $vehicle = $this->invaratVehicleRepository->createVehicle($request);
//        $this->invaratPendingTaskRepository->create($vehicle['id']);

        try{

            $order = Order::query()->where("vehicle_id",$request->input("vehicle_id"))->first();

            if(!$order){

                $order = new Order();
                $order->vehicle_id =         $request->input("vehicle_id");
            }

            if($request->input("id_gsp") != ""){
                $order->id_gsp =             $request->input("id_gsp");
            }

            if($request->input("id_gsp_peritacion") != ""){
                $order->id_gsp_peritacion =  $request->input("id_gsp_peritacion");
            }

            if($request->input("id_gsp_certificado") != ""){
                $order->id_gsp_certificado = $request->input("id_gsp_certificado");
            }

            if(!$order->save()){
                throw new \Exception("Error al generar el registro orden de GSP20");
            }

            return [
                "type" => "success",
                "msg" => ""
            ];

        }catch (\Exception $e){

            return [
                "type" => "error",
                "msg" => $e->getMessage()
            ];

        }

    }

    public function orderFilter($request){
        return Order::with($this->getWiths($request->with))
                    ->filter($request->all())
                    ->paginate($request->input('per_page'));
    }

    public function getVehiclesForIdGspOrder($request){

        $idsGsp = $request->ordersIds;

        $query = Vehicle::with($this->getWiths($request->with))
            ->whereHas("orders", function ($order) use ($idsGsp){
                $order->whereIn("id_gsp",array($idsGsp));
            })
            ->filter($request->all());

        if ($request->input('noPaginate')) {
            $vehicles = [
                'data' => $query->get()
            ];
        } else {
            $vehicles =  $query->paginate($request->input('per_page') ?? 5);
        }

        return ['vehicles' => $vehicles];
    }

}
