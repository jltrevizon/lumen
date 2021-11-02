<?php

namespace App\Repositories;

use App\Models\Damage;
use Exception;

class DamageRepository extends Repository {

    public function index($request){
        return Damage::with($this->getWiths($request->with))
            ->filter($request->all())
            ->paginate();
    }

    public function store($request){
        $damage = Damage::create($request->all());
        return $damage;
    }

    public function update($request, $id){
        $damage = Damage::findOrFail($id);
        $damage->update($request->all());
        return $damage;
    }

}
