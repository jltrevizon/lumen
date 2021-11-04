<?php

namespace App\Repositories;

use App\Models\Accessory;
use Exception;
use Illuminate\Database\Eloquent\Builder;

class AccessoryRepository extends Repository {

    public function index($request){
        return Accessory::with($this->getWiths($request->all()))
            ->filter($request->all())
            ->get();
    }

    public function store($request){
        $accessory = Accessory::create($request->all());
        return $accessory;
    }

    public function update($request, $id){
        $accessory = Accessory::findOrFail($id);
        $accessory->update($request->all());
        return $accessory;
    }

}
