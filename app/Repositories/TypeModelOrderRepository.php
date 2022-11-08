<?php

namespace App\Repositories;

use App\Models\Transport;
use App\Models\TypeModelOrder;
use Exception;

class TypeModelOrderRepository extends Repository {

    public function getAll(){
        return TypeModelOrder::with($this->getWiths($request->with))
            ->filter($request->all())
            ->paginate($request->input('per_page'));
    }

    public function getByName($name){
        return TypeModelOrder::where('name', $name)
                ->first();
    }

}
