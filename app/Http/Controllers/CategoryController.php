<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Repositories\CategoryRepository;

class CategoryController extends Controller
{

    public function __construct(CategoryRepository $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }

    public function getAll(){
        return Category::all();
    }

    public function getById($id){
        return Category::where('id', $id)
                        ->first();
    }

    public function create(Request $request){

        $this->validate($request, [
            'name' => 'required|string'
        ]);

        return $this->categoryRepository->create($request);
    }

    public function update(Request $request, $id){
        return $this->categoryRepository->create($request, $id);
    }

    public function delete($id){
        Category::where('id', $id)
                ->delete();
        return [
            'message' => 'Category deleted'
        ];
    }
}
