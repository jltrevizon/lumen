<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Role;
use App\Repositories\RoleRepository;
use DateTime;
use Symfony\Component\HttpFoundation\Response as HttpFoundationResponse;

class RoleController extends Controller
{

    public function __construct(RoleRepository $roleRepository)
    {
        $this->roleRepository = $roleRepository;
    }

    /**
    * @OA\Get(
    *     path="/api/roles/getall",
    *     tags={"roles"},
    *     summary="Get all roles",
    *     @OA\Response(
    *         response=200,
    *         description="Successful operation",
    *         value={@OA\JsonContent(ref="#/components/schemas/User")},
    *    ),
    *     @OA\Response(
    *         response="500",
    *         description="An error has occurred."
    *     )
    * )
    */

    public function getAll(Request $request){
        return $this->getDataResponse($this->roleRepository->index($request), HttpFoundationResponse::HTTP_OK);
    }

    /**
    * @OA\Get(
    *     path="/api/roles/{id}",
    *     tags={"roles"},
    *     summary="Get role by ID",
    *     @OA\Parameter(
    *         name="id",
    *         in="path",
    *         required=true,
    *         @OA\Schema(
    *             type="string"
    *         )
    *     ),
    *     @OA\Response(
    *         response=200,
    *         description="Successful operation",
    *         @OA\JsonContent(ref="#/components/schemas/Role"),
    *    ),
    *     @OA\Response(
    *         response="404",
    *         description="Role not found."
    *     )
    * )
    */

    public function getById($id){
        return $this->getDataResponse($this->roleRepository->getById($id), HttpFoundationResponse::HTTP_OK);
    }

    public function create(Request $request){

        $this->validate($request, [
            'description' => 'required|string'
        ]);

        return $this->createDataResponse($this->roleRepository->create($request), HttpFoundationResponse::HTTP_CREATED);
    }

    /**
     * @OA\Put(
     *     path="/roles/update/{id}",
     *     tags={"roles"},
     *     summary="Updated role",
     *     @OA\RequestBody(
     *         description="Updated role object",
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/Role")
     *     ),
     *     operationId="updateRole",
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
     *         @OA\JsonContent(ref="#/components/schemas/Role"),
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Role not found"
     *     ),
     * )
     */

    public function update(Request $request, $id){
        return $this->updateDataResponse($this->roleRepository->update($request, $id), HttpFoundationResponse::HTTP_OK);
    }

    public function delete($id){
        return $this->deleteDataResponse($this->roleRepository->delete($id), HttpFoundationResponse::HTTP_OK);
    }
}
