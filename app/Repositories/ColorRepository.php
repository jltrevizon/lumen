<?php

namespace App\Repositories;

use App\Models\Color;
use App\Repositories\Repository;

class ColorRepository extends Repository {

    public function index($request){
        return Color::with($this->getWiths($request->with))
        ->filter($request->all())
        ->get();
    }

    public function getOrCreateColor($color){
        $newColor = Color::where('name', $color)->first();
        if($newColor){
            return $newColor;
        } else {
            return Color::create([
                'name' => $color
            ]);
        }
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