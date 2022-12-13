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
    *     security={
    *          {"bearerAuth": {}}
    *     },
    *     @OA\Parameter(
    *       name="with[]",
    *       in="query",
    *       description="A list of relatonship",
    *       required=false,
    *       @OA\Schema(
    *           type="array",
    *           example={"relationship1","relationship2"},
    *           @OA\Items(type="string")
    *       )
    *     ),
    *     @OA\Response(
    *         response=200,
    *         description="Successful operation",
    *         value= @OA\JsonContent(
    *           type="array",
    *           @OA\Items(ref="#/components/schemas/Category")
    *         ),
    *     ),
    *     @OA\Response(
    *         response="500",
    *         description="An error has occurred."
    *     )
    * )
    */

    public function index(Request $request){
        return $this->getDataResponse($this->categoryRepository->index($request), HttpFoundationResponse::HTTP_OK);
    }

    /**
    * @OA\Get(
    *     path="/api/categories/{id}",
    *     tags={"categories"},
    *     summary="Get category by ID",
    *     security={
    *          {"bearerAuth": {}}
    *     },
    *     @OA\Parameter(
    *         name="id",
    *         in="path",
    *         required=true,
    *         @OA\Schema(
    *             type="integer"
    *         )
    *     ),
    *     @OA\Response(
    *         response=200,
    *         description="Successful operation",
    *         @OA\JsonContent(ref="#/components/schemas/Category"),
    *    ),
    *     @OA\Response(
    *         response="404",
    *         description="Category not found."
    *     )
    * )
    */

    public function show($id){
        return $this->getDataResponse($this->categoryRepository->show($id), HttpFoundationResponse::HTTP_OK);
    }

    /**
     * @OA\Post(
     *     path="/api/categories",
     *     tags={"categories"},
     *     summary="Create category",
     *     security={
     *          {"bearerAuth": {}}
     *     },
     *     operationId="createCategory",
     *     @OA\Response(
     *         response="201",
     *         description="Successful operation",
     *         @OA\JsonContent(ref="#/components/schemas/Category"),
     *     ),
     *     @OA\RequestBody(
     *         description="Create category object",
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/Category"),
     *     )
     * )
     */

    public function create(Request $request){

        $this->validate($request, [
            'name' => 'required|string'
        ]);

        return $this->getDataResponse($this->categoryRepository->create($request), HttpFoundationResponse::HTTP_CREATED);
    }

    /**
     * @OA\Put(
     *     path="/api/categories/update/{id}",
     *     tags={"categories"},
     *     summary="Updated category",
     *     security={
     *          {"bearerAuth": {}}
     *     },
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
     *             type="integer"
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         value = @OA\JsonContent(
     *              @OA\Property(
     *                  property="category",
     *                  type="object",
     *                  ref="#/components/schemas/Category"
     *              ),
     *          ),
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

    /**
     * @OA\Delete(
     *     path="/api/categories/delete/{id}",
     *     summary="Delete category",
     *     tags={"categories"},
     *     operationId="deleteCategory",
     *     security={
     *          {"bearerAuth": {}}
     *     },
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="The id that needs to be deleted",
     *         required=true,
     *         @OA\Schema(
     *             type="integer"
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="",
     *         value = @OA\JsonContent(
     *              @OA\Property(
     *                  property="message",
     *                  type="string",
     *              ),
     *          ),
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Category not found",
     *     )
     * )
     */

    public function delete($id){
        Category::where('id', $id)
                ->delete();
        return [
            'message' => 'Category deleted'
        ];
    }
}
