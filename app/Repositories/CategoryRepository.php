<?php

namespace App\Repositories;

use App\Models\Category;
use Exception;

class CategoryRepository {

    public function __construct()
    {

    }

    public function searchCategoryByName($name){
        try {
            return Category::where('name', $name)
                        ->first();
        } catch (Exception $e){
            return response()->json(['message' => $e->getMessage()], 409);
        }
    }

    public function create($request){
        try {
            $category = new Category();
            $category->name = $request->get('name');
            if(isset($request['description'])) $category->description = $request->get('description');
            $category->save();
            return $category;
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], 409);
        }
    }

    public function update($request, $id){
        try {
            $category = Category::where('id', $id)
                                ->first();
            if(isset($request['name'])) $category->name = $request->get('name');
            if(isset($request['description'])) $category->description = $request->get('description');
            $category->updated_at = date('Y-m-d H:i:s');
            $category->save();
            return $category;
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], 409);
        }
    }
}
