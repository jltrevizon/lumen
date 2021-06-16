<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Repositories\UserRepository;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function getAll(){
        return User::with(['campas','company'])
                    ->get();
    }

    public function getById($id){
        return $this->userRepository->getById($id);
    }

    public function create(Request $request){
        return $this->userRepository->create($request);
    }

    public function createUserWithoutPassword(Request $request){
        return $this->userRepository->createUserWithoutPassword($request);
    }

    public function update(Request $request, $id){
        return $this->userRepository->update($request, $id);
    }

    public function delete($id){
        return $this->userRepository->delete($id);
    }

    public function getUsersByCampa($campa_id){
        return $this->userRepository->getUsersByCampa($campa_id);
    }

    public function getUsersByRole(Request $request, $role_id){
        return $this->userRepository->getUsersByRole($request, $role_id);
    }

    public function getActiveUsers(Request $request){
        return $this->userRepository->getActiveUsers($request);
    }

    public function getUserByEmail(Request $request){
        return $this->userRepository->getUserByEmail($request);
    }
}
