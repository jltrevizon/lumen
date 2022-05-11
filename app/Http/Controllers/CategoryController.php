<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Repositories\CategoryRepository;
use Symfony\Component\HttpFoundation\Response as HttpFoundationResponse;

class CategoryController extends Controller
{

    public function __construct(CategoryRepository $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }

    public function index(Request $request){
        return $this->getDataResponse($this->categoryRepository->index($request), HttpFoundationResponse::HTTP_OK);
    }

    public function show($id){
        return $this->getDataResponse($this->categoryRepository->show($id), HttpFoundationResponse::HTTP_OK);
    }

    public function create(Request $request){

        $this->validate($request, [
            'name' => 'required|string'
        ]);

        return $this->getDataResponse($this->categoryRepository->create($request), HttpFoundationResponse::HTTP_CREATED);
    }

    public function update(Request $request, $id){
        return $this->getDataResponse($this->categoryRepository->update($request, $id), HttpFoundationResponse::HTTP_OK);
    }

    public function delete($id){
        Category::where('id', $id)
                ->delete();
        return [
            'message' => 'Category deleted'
        ];
    }
}
