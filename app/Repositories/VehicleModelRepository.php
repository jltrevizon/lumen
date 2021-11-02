<?php

namespace App\Repositories;

use App\Models\VehicleModel;
use Exception;
use Illuminate\Database\Eloquent\Builder;

class VehicleModelRepository {

    public function __construct()
    {

    }

    public function getAll(){
        return VehicleModel::all();
    }

    public function store($request){
        $vehicle_model = VehicleModel::create($request->all());
        return $vehicle_model;
    }

    public function getByNameFromExcel($brand_id, $vehicle_name){
        try {
            $vehicle_model = VehicleModel::where('name', $vehicle_name)
                                    ->first();
            if(!$vehicle_model){
                return $this->create($brand_id, $vehicle_name);
            }
            return $vehicle_model;
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], 409);
        }
    }

    public function create($brand_id, $name_model){
        try{
            $vehicleModel = new VehicleModel();
            $vehicleModel->brand_id = $brand_id;
            $vehicleModel->name = $name_model;
            $vehicleModel->save();
            return $vehicleModel;
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], 409);
        }
    }

    public function update($request, $id){
        $vehicleModel = VehicleModel::findOrFail($id);
        $vehicleModel->update($request->all());
        $vehicleModel->save();
        return $vehicleModel;
    }

}
