<?php

namespace App\Repositories;

use App\Models\SeverityDamage;

class SeverityDamageRepository extends Repository {

    public function index(){
        return SeverityDamage::all();
    }

    public function store($request){
        $damage = SeverityDamage::create($request->all());
        $damage->save();
        return $damage;
    }

    public function update($request, $id){
        $damage = SeverityDamage::findOrFail($id);
        $damage->update($request->all());
        return $damage;
    }

}
