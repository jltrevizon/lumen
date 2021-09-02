<?php

namespace App\Repositories;

use App\Models\Transport;
use App\Models\TypeModelOrder;
use Exception;

class TypeModelOrderRepository {

    public function getAll(){
        return TypeModelOrder::all();
    }

}
