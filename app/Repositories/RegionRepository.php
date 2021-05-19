<?php

namespace App\Repositories;

use App\Models\Question;
use App\Models\Region;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class RegionRepository {

    public function __construct()
    {

    }

    public function getById($id){
        return Region::where('id', $id)
                        ->first();
    }

    public function create($request){
        $region = new Region();
        $region->name = $request->get('name');
        $region->save();
        return $region;
    }

    public function update($request, $id){
        $region = Region::where('id', $id)
                            ->first();
        $region->name = $request->get('name');
        $region->updated_at = date('Y-m-d H:i:s');
        $region->save();
        return $region;
    }

    public function delete($id){
        Region::where('id', $id)
                ->delete();
        return [
            'message' => 'Region deleted'
        ];
    }
}
