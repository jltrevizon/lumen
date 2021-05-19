<?php

namespace App\Repositories;

use App\Models\Incidence;

class IncidenceRepository {

    public function __construct()
    {

    }

    public function getById($id){
        return Incidence::where('id', $id)
                    ->first();
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
        $incidence->description = $request->json()->get('description');
        $incidence->resolved = false;
        $incidence->save();
        return $incidence;
    }

    public function resolved($request){
        $incidence = Incidence::where('id', $request->json()->get('incidence_id'))
                            ->first();
        $incidence->resolved = true;
        $incidence->save();
    }

    public function update($request, $id){
        $incidence = Incidence::where('id', $id)
                        ->first();
        if(isset($request['description'])) $incidence->description = $request->get('description');
        if(isset($request['resolved'])) $incidence->resolved = $request->get('resolved');
        $incidence->updated_at = date('Y-m-d H:i:s');
        $incidence->save();
        return $incidence;
    }

    public function delete($id){
        Incidence::where('id', $id)
            ->delete();

        return [ 'message' => 'Incidence deleted' ];
    }
}
