<?php

namespace App\Repositories;

use App\Models\Category;

class CategoryRepository {

    public function __construct()
    {

    }

    public function create($request){
        $category = new Category();
        $category->name = $request->get('name');
        if(isset($request['description'])) $category->description = $request->get('description');
        $category->save();
        return $category;
    }

    public function update($request, $id){
        $category = Category::where('id', $id)
                            ->first();
        if(isset($request['name'])) $category->name = $request->get('name');
        if(isset($request['description'])) $category->description = $request->get('description');
        $category->updated_at = date('Y-m-d H:i:s');
        $category->save();
        return $category;
    }
}
