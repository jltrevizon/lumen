<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Repositories\UserRepository;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\Response as HttpFoundationResponse;

class UserController extends Controller
{
    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function getAll(Request $request){
        return $this->getDataResponse($this->userRepository->getAll($request), HttpFoundationResponse::HTTP_OK);
    }

    public function getById(Request $request, $id){
        return $this->getDataResponse($this->userRepository->getById($request, $id), HttpFoundationResponse::HTTP_OK);
    }

    public function create(Request $request){

        $this->validate($request, [
            'name' => 'required|string',
            'email' => 'required|email|unique:users',
            'password' => 'required|string'
        ]);

        return $this->createDataResponse($this->userRepository->create($request), HttpFoundationResponse::HTTP_CREATED);
    }

    public function createUserWithoutPassword(Request $request){

        $this->validate($request, [
            'name' => 'required|string',
            'email' => 'required|email|unique:users'
        ]);

        return $this->createDataResponse($this->userRepository->createUserWithoutPassword($request), HttpFoundationResponse::HTTP_CREATED);
    }

    public function update(Request $request, $id){
        return $this->updateDataResponse($this->userRepository->update($request, $id), HttpFoundationResponse::HTTP_OK);
    }

    public function delete($id){
        return $this->deleteDataResponse($this->userRepository->delete($id), HttpFoundationResponse::HTTP_OK);
    }

    public function getUsersByCampa($campa_id){
        return $this->getDataResponse($this->userRepository->getUsersByCampa($campa_id), HttpFoundationResponse::HTTP_OK);
    }

    public function getUsersByRole(Request $request, $role_id){
        return $this->getDataResponse($this->userRepository->getUsersByRole($request, $role_id), HttpFoundationResponse::HTTP_OK);
    }

    public function getActiveUsers(Request $request){

        $this->validate($request, [
            'campa_id' => 'required|integer'
        ]);

        return $this->getDataResponse($this->userRepository->getActiveUsers($request), HttpFoundationResponse::HTTP_OK);
    }

}
