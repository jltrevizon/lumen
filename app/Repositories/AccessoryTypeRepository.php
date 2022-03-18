<?php

namespace App\Repositories;

use App\Models\Accessory;
use App\Models\AccessoryType;
use Exception;
use Illuminate\Database\Eloquent\Builder;

class AccessoryTypeRepository extends Repository {

    public function index($request){
        return AccessoryType::with($this->getWiths($request->with))
            ->filter($request->all())
            ->get();
    }


}
