<?php

namespace App\Repositories;

use App\Models\DamageImage;
use Exception;

class DamageImageRepository extends Repository {

    public function index($request){
        return DamageImage::with($this->getWiths($request->with))
            ->filter($request->all())
            ->paginate();
    }

    public function store($request){
        $damageImage = DamageImage::create($request->all());
        return $damageImage;
    }

    public function update($request, $id){
        $damageImage = DamageImage::findOrFail($id);
        $damageImage->update($request->all());
        return $damageImage;
    }

}
