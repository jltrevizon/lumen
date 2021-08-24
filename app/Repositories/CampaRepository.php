<?php

namespace App\Repositories;

use App\Models\Campa;

class CampaRepository extends Repository {

    public function __construct()
    {

    }

    public function getAll($request){
        return Campa::with($this->getWiths($request->with))
                ->filter($request->all())
                ->get();
    }

    public function getById($request, $id){
        return Campa::with($this->getWiths($request->with))
                ->findOrFail($id);
    }

    public function create($request){
        $campa = Campa::create($request->all());
        return $campa;
    }

    public function update($request, $id){
        $campa = Campa::findOrFail($id);
        $campa->update($request->all());
        return ['campa' => $campa];
    }
}
