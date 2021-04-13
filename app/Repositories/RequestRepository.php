<?php

namespace App\Repositories;
use App\Models\Request as RequestVehicle;

class RequestRepository {

    public function getById($id){
        return RequestVehicle::where('id', $id)
                        ->first();
    }

}
