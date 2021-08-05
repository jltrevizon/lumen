<?php

namespace App\Repositories\Invarat;

use App\Models\Accessory;
use App\Models\Vehicle;
use App\Models\Workshop;
use Exception;
use Illuminate\Database\Eloquent\Builder;
use stdClass;

class InvaratWorkshopRepository {

    public function __construct()
    {

    }

    public function createWorkshop($workshop){
        $newWorkshop = new Workshop();
        $newWorkshop->name = $workshop['name'];
        $newWorkshop->cif = $workshop['cif'];
        $newWorkshop->province = $workshop['province'];
        $newWorkshop->location = $workshop['location'];
        $newWorkshop->address = $workshop['address'];
        $newWorkshop->phone = $workshop['phone'];
        $newWorkshop->save();
        return $newWorkshop;
    }

}
