<?php

namespace App\Repositories;

use App\Models\Region;

class RegionRepository {

    public function __construct()
    {

    }

    public function getById($id){
            return Region::findOrFail($id);
    }

    public function create($request){
        $region = Region::create($request->all());
        $region->save();
        return $region;
    }

    public function update($request, $id){
        $region = Region::findOrFail($id);
        $region->update($request->all());
        return ['region' => $region];
}

    public function delete($id){
        Region::where('id', $id)
                ->delete();
        return [ 'message' => 'Region deleted' ];
    }
}
