<?php

namespace App\Repositories;

use App\Models\Color;
use App\Repositories\Repository;
use Illuminate\Support\Facades\DB;

class ColorRepository extends Repository {

    public function index(){
        return Color::all();
    }

    public function store($request){
        $color = Color::create($request->all());
        return $color;
    }

    public function update($request, $id){
        $color = Color::findOrFail($id);
        $color->update($request->all());
        return $color;
    }

}