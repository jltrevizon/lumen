<?php

namespace App\Repositories;

use App\Models\Vehicle;
use App\Models\VehiclePicture;
use Illuminate\Support\Facades\Auth;

class VehiclePictureRepository extends Repository {

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function create($request){
        $vehicle = Vehicle::with(['lastReception'])
                    ->findOrFail($request->input('vehicle_id'));
        $vehicle_picture = new VehiclePicture();
        $vehicle_picture->reception_id = $vehicle['lastReception']['id'] ?? null;
        $vehicle_picture->vehicle_id = $request->input('vehicle_id');
        $vehicle_picture->user_id = Auth::id();
        $vehicle_picture->url = $request->input('url');
        $vehicle_picture->place = $request->input('place');
        $vehicle_picture->latitude = $request->input('latitude');
        $vehicle_picture->longitude = $request->input('longitude');
        $vehicle_picture->save();
        return VehiclePicture::where('vehicle_id', $request->input('vehicle_id'))
                ->get();
    }

    public function getPicturesByVehicle($request){
        return VehiclePicture::with($this->getWiths($request->with))
                    ->where('vehicle_id', $request->input('vehicle_id'))
                    ->get();
    }

    public function deletePictureByReception($reception){
        VehiclePicture::where('vehicle_id', $reception['id'])
            ->delete();
        return ['message' => 'Pictures deleted'];
    }

    /*
     * Método para borrar imagenes de un determinado vehículo y lugar
     *
     */
    public function deletePictureByPlace($request){
        $pictures = VehiclePicture::where('vehicle_id', $request->input['vehicle_id'])
            ->where('place', $request->input['place'])
            ->get();

        if($pictures){

            foreach($pictures as $pic){
                $pic->delete();
            }

            return ['message' => 'Pictures deleted'];
        }else{
            return ['message' => 'Picture not found'];
        }

    }

    public function delete($id){

        $pic = VehiclePicture::find($id);

        if($pic){
            $pic->delete();
            return ['message' => 'Picture deleted'];
        }else{
            return ['message' => 'Picture not found'];
        }

    }



}
