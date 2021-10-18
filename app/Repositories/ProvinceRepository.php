<?php

namespace App\Repositories;

use App\Models\Province;
use Exception;

class ProvinceRepository extends Repository {

    public function getAll($request){
        return Province::with($this->getWiths($request->with))
            ->filter($request->all())
            ->paginate($request->input('per_page'));
    }

    public function getById($id){
        return ['province' => Province::findOrFail($id)];
    }

    public function create($request){
        $province = Province::create($request->all());
        $province->save();
        return $province;
    }

    public function update($request, $id){
        $province = Province::findOrFail($id);
        $province->update($request->all());
        return ['province' => $province];
    }

    public function delete($id){
        Province::where('id', $id)
                ->delete();
        return [ 'message' => 'Province deleted' ];
    }
}
