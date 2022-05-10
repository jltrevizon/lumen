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

    public function store($request){
        $accessoryType = AccessoryType::create($request->all());
        return $accessoryType;
    }

    public function show($id){
        return AccessoryType::findOrFail($id);
    }

    public function update($request, $id){
        $accessoryType = AccessoryType::findOrFail($id);
        $accessoryType->update($request->all());
        return $accessoryType;
    }

    public function destroy($id){
        return AccessoryType::findOrFail($id)->delete();
    }

}
