<?php

namespace App\Repositories;

use App\Models\Reception;

class ReceptionRepository {

    public function __construct()
    {

    }

    public function create($vehicle_id, $has_accessories){
        $reception = new Reception();
        $reception->vehicle_id = $vehicle_id;
        $reception->has_accessories = $has_accessories;
        $reception->save();
        return $reception;
    }

}
