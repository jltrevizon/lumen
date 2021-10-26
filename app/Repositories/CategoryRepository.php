<?php

namespace App\Repositories;

use App\Models\Category;
use Exception;

class CategoryRepository extends Repository {

    public function __construct()
    {

    }

    public function getAll($request){
        return Category::with($this->getWiths($request->with))
            ->filter($request->all())
            ->get();
    }

    public function getById($id){
        return Category::findOrFail($id);
    }

    public function searchCategoryByName($name){
        return Category::where('name', $name)
                ->first();
    }

    public function create($request){
        $category = Category::create($request->all());
        $category->save();
        return $category;
    }

    public function update($request, $id){
        $category = Category::findOrFail($id);
        $category->update($request->all());
        return ['category' => $category];
    }
}
