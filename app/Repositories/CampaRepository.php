<?php

namespace App\Repositories;

use App\Models\Campa;

class CampaRepository extends Repository {

    public function __construct()
    {

    }

    public function index($request){
        return Campa::with($this->getWiths($request->with))
                ->filter($request->all())
                ->get();
    }

    public function show($request, $id){
        return Campa::with($this->getWiths($request->with))
                ->findOrFail($id);
    }

    public function getByName($name){
        return Campa::where('name', $name)
                    ->first();
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
