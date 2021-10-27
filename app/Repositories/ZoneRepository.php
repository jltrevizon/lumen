<?php

namespace App\Repositories;
use App\Models\Tax;
use App\Models\Zone;

class ZoneRepository extends Repository {

    public function index($request){
        return Zone::with($this->getWiths($request->with))
            ->filter($request->all())
            ->get();
    }

    public function store($reqeust){
        $zone = Zone::create($reqeust->all());
        return $zone;
    }

    public function update($request, $id){
        $zone = Zone::findOrFail($id);
        $zone->update($request->all());
        return $zone;
    }

}
