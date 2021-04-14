<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Incidence;
use App\Repositories\IncidenceRepository;

class IncidenceController extends Controller
{

    public function __construct(IncidenceRepository $incidenceRepository)
    {
        $this->incidenceRepository = $incidenceRepository;
    }

    public function getAll(){
        return Incidence::all();
    }

    public function getById($id){
        return Incidence::where('id', $id)
                    ->first();
    }

    public function create(Request $request){
        return $this->incidenceRepository->create($request);
    }

    public function createIncidence($request){
        return $this->incidenceRepository->createIncidence($request);
    }

    public function resolved($request){
        return $this->incidenceRepository->resolved($request);
    }

    public function update(Request $request, $id){
        return $this->incidenceRepository->update($request, $id);
    }

    public function delete($id){
        return $this->incidenceRepository->delete($id);
    }
}
