<?php

namespace App\Repositories;

use App\Models\Street;

class StreetRepository extends Repository {

    public function index($request){
        return Street::with($this->getWiths($request->with))
            ->filter($request->all())
            ->get();
    }

    public function store($request){
        $street = Street::create($request->all());
        return $street;
    }

    public function update($request, $id){
        $street = Street::findOrFail($id);
        $street->update($request->all());
        return $street;
    }

}
