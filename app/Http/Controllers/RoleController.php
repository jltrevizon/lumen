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

    public function getAll(){
        return $this->getDataResponse(Role::all(), HttpFoundationResponse::HTTP_OK);
    }

    public function getById($id){
        return $this->getDataResponse($this->roleRepository->getById($id), HttpFoundationResponse::HTTP_OK);
    }

    public function create(Request $request){

        $this->validate($request, [
            'description' => 'required|string'
        ]);

        return $this->createDataResponse($this->roleRepository->create($request), HttpFoundationResponse::HTTP_CREATED);
    }

    public function update(Request $request, $id){
        return $this->updateDataResponse($this->roleRepository->update($request, $id), HttpFoundationResponse::HTTP_OK);
    }

    public function delete($id){
        return $this->deleteDataResponse($this->roleRepository->delete($id), HttpFoundationResponse::HTTP_OK);
    }
}
