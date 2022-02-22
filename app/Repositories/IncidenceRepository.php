<?php

namespace App\Repositories;

use App\Models\Incidence;
use App\Models\IncidenceType;

use Exception;

class IncidenceRepository extends Repository {

    public function __construct()
    {

    }

    public function getAll($request){
        return Incidence::with($this->getWiths($request->with)) 
            ->filter($request->all())
            ->paginate($request->input('per_page'));
    }

    public function getAllTypes($request){
        return IncidenceType::all();
    }

    public function getById($id){
        return Incidence::findOrFail($id);
    }

    public function create($request){
        $incidence = Incidence::create($request->all());
        $incidence->save();
        return $incidence;
    }

    public function createIncidence($request){
        $incidence = Incidence::create($request->all());
        return $incidence;
    }

    public function resolved($request){
        $incidence = Incidence::findOrFail($request->input('incidence_id'));
        $incidence->resolved = true;
        $incidence->save();
        return $incidence;
    }

    public function update($request, $id){
        $incidence = Incidence::findOrFail($id);
        $incidence->update($request->all());
        return ['incidence' => $incidence];
    }

    public function delete($id){
        Incidence::where('id', $id)
            ->delete();

        return [ 'message' => 'Incidence deleted' ];
    }
}
