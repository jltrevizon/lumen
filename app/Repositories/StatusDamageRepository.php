<?php

namespace App\Repositories;

use App\Models\StatusDamage;
use Exception;
use Illuminate\Support\Facades\Auth;

class StatusDamageRepository extends Repository {

    public function index(){
        return StatusDamage::all();
    }

    public function store($request){
        $damage = StatusDamage::create($request->all());
        $damage->user_id = Auth::id();
        $damage->save();
        return $damage;
    }

    public function update($request, $id){
        $damage = StatusDamage::findOrFail($id);
        $damage->update($request->all());
        return $damage;
    }

}
