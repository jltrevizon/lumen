<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;

class CategoryController extends Controller
{
    public function getAll(){
        return Category::all();
    }

    public function getById($id){
        return Category::where('id', $id)
                        ->first();
    }

    public function create(Request $request){
        $category = new Category();
        $category->name = $request->get('name');
        if(isset($request['description'])) $category->description = $request->get('description');
        $category->save();
        return $category;
    }

    public function update(Request $request, $id){
        $category = Category::where('id', $id)
                            ->first();
        if(isset($request['name'])) $category->name = $request->get('name');
        if(isset($request['description'])) $category->description = $request->get('description');
        $category->updated_at = date('Y-m-d H:i:s');
        $category->save();
        return $category;
    }

    public function delete($id){
        Category::where('id', $id)
                ->delete();
        return [
            'message' => 'Category deleted'
        ];
    }
}
