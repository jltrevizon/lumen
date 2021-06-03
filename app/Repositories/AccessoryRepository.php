<?php

namespace App\Repositories;

use App\Models\Accessory;
use Illuminate\Database\Eloquent\Builder;

class AccessoryRepository {

    public function __construct()
    {

    }

    public function create($reception_id, $accessories){
        foreach($accessories as $accessory){
            $new_accessory = new Accessory();
            $new_accessory->reception_id = $reception_id;
            $new_accessory->name = $accessory['name'];
            $new_accessory->save();
        }

    }

}
