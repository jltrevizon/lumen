<?php

namespace App\Repositories;

use App\Models\Questionnaire;
use App\Models\Vehicle;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class QuestionnaireRepository extends Repository {

    public function __construct()
    {

    }

    public function index($request){
        return Questionnaire::with($this->getWiths($request->with))
            //->whereRaw('vehicle_id NOT IN(SELECT id FROM vehicles WHERE deleted_at is not null)')
            ->whereNotNull('deleted_at')
            ->filter($request->all())
            ->paginate($request->input('per_page'));
    }

    public function create($vehicleId){
        $vehicle = Vehicle::findOrFail($vehicleId);
        return  Questionnaire::create([
            'user_id' => Auth::id(),
            'vehicle_id' => $vehicle->id,
            'reception_id' =>  $vehicle->lastReception->id
        ]);
    }

    public function getById($request, $id){
        return Questionnaire::with($this->getWiths($request->with))
                    ->findOrFail($id);
    }

}
