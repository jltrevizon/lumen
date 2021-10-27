<?php

namespace App\Repositories;

use App\Models\Square;

class SquareRepository extends Repository {

    public function index($request){
        return Square::with($this->getWiths($request->with))
            ->filter($request->all())
            ->get();
    }

    public function store($request){
        $square = Square::create($request->all());
        return $square;
    }

    public function update($request, $id){
        $square = Square::findOrFail($id);
        $square->update($request->all());
        return $square;
    }

}
