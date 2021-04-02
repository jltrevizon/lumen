<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Region;

class RegionController extends Controller
{
    public function getAll(){
        return Region::all();
    }

    public function getById($id){
        return Region::where('id', $id)
                        ->first();
    }

    public function create(Request $request){
        $region = new Region();
        $region->name = $request->get('name');
        $region->save();
        return $region;
    }

    public function update(Request $request, $id){
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
