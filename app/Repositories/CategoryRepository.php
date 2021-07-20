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
            $category = Category::create($request->all());
            $category->save();
            return $category;
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], 409);
        }
    }

    public function update($request, $id){
        try {
            $category = Category::findOrFail($id);
            $category->update($request->all());
            return response()->json(['category' => $category], 200);
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], 409);
        }
    }
}
