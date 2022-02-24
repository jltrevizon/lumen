<?php

use App\Models\DamageType;
use App\Repositories\Repository;

class DamageTypeRepository extends Repository {

    public function index($request){
        return DamageType::with($this->getWiths($request->with))
            ->get();
    }

}