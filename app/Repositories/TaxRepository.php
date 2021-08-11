<?php

namespace App\Repositories;
use App\Models\Tax;

class TaxRepository {

    public function byId($id){
        return Tax::findOrFail($id);
    }

}
