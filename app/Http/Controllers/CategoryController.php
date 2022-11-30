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

    /**
    * @OA\Get(
    *     path="/api/categories/getall",
    *     tags={"categories"},
    *     summary="Get all categories",
    *     @OA\Response(
    *         response=200,
    *         description="successful operation",
    *         @OA\JsonContent(ref="#/components/schemas/Category"),
    *    ),
    *     @OA\Response(
    *         response="500",
    *         description="An error has occurred."
    *     )
    * )
    */

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

    /**
     * @OA\Put(
     *     path="/categories/update/{id}",
     *     tags={"categories"},
     *     summary="Updated category",
     *     @OA\RequestBody(
     *         description="Updated category object",
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/Category")
     *     ),
     *     operationId="updateCategory",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="id that to be updated",
     *         required=true,
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(ref="#/components/schemas/Category"),
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Category not found"
     *     ),
     * )
     */

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
