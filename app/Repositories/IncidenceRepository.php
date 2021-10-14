<?php

namespace App\Repositories;

use App\Models\Incidence;
use Exception;

class IncidenceRepository {

    public function __construct()
    {

    }

    public function getAll(){
        return Incidence::all();
    }

    public function getById($id){
        return Incidence::findOrFail($id);
    }

    public function create($request){
        $incidence = new Incidence();
        $incidence->description = $request->get('description');
        $incidence->resolved = false;
        $incidence->save();
        return $incidence;
    }

    public function createIncidence($request){
        $incidence = new Incidence();
        $incidence->description = $request->input('description');
        $incidence->resolved = false;
        $incidence->save();
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
