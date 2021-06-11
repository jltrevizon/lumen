<?php

namespace App\Repositories;

use App\Models\Incidence;
use Exception;

class IncidenceRepository {

    public function __construct()
    {

    }

    public function getById($id){
        try {
            return Incidence::where('id', $id)
                        ->first();
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], 409);
        }
    }

    public function create($request){
        try {
            $incidence = new Incidence();
            $incidence->description = $request->get('description');
            $incidence->resolved = false;
            $incidence->save();
            return $incidence;
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], 409);
        }
    }

    public function createIncidence($request){
        try {
            $incidence = new Incidence();
            $incidence->description = $request->json()->get('description');
            $incidence->resolved = false;
            $incidence->save();
            return $incidence;
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], 409);
        }
    }

    public function resolved($request){
        try {
            $incidence = Incidence::where('id', $request->json()->get('incidence_id'))
                                ->first();
            $incidence->resolved = true;
            $incidence->save();
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], 409);
        }
    }

    public function update($request, $id){
        try {
            $incidence = Incidence::where('id', $id)
                            ->first();
            if(isset($request['description'])) $incidence->description = $request->get('description');
            if(isset($request['resolved'])) $incidence->resolved = $request->get('resolved');
            $incidence->updated_at = date('Y-m-d H:i:s');
            $incidence->save();
            return $incidence;
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], 409);
        }
    }

    public function delete($id){
        try {
            Incidence::where('id', $id)
                ->delete();

            return [ 'message' => 'Incidence deleted' ];
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], 409);
        }
    }
}
