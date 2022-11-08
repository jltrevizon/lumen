<?php

namespace App\Repositories;

use App\Models\Transport;
use App\Models\TypeModelOrder;
use Exception;

class TypeModelOrderRepository {

    public function getAll(){
        return TypeModelOrder::all();
    }

    public function getByName($name){
        return TypeModelOrder::where('name', $name)
                ->first();
    }

}
