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
        return User::with(['campa'])
                    ->get();
    }

    public function getById($id){
        return $this->userRepository->getById($id);
    }

    public function create(Request $request){
        $user = new User();
        $user->name = $request->json()->get('name');
        $user->email = $request->json()->get('email');
        $user->password = Hash::make($request->json()->get('password'));
        if($request->json()->get('role_id')) $user->role_id = $request->json()->get('role_id');
        if($request->json()->get('campa_id')) $user->campa_id = $request->json()->get('campa_id');
        if($request->json()->get('avatar')) $user->avatar = $request->json()->get('avatar');
        if($request->json()->get('phone')) $user->phone = $request->json()->get('phone');
        $user->save();
        return $user;
    }

    public function createUserWithoutPassword(Request $request){
        $user = new User();
        $user->name = $request->json()->get('name');
        $user->email = $request->json()->get('email');
        if($request->json()->get('role_id')) $user->role_id = $request->json()->get('role_id');
        if($request->json()->get('campa_id')) $user->campa_id = $request->json()->get('campa_id');
        if($request->json()->get('avatar')) $user->avatar = $request->json()->get('avatar');
        if($request->json()->get('phone')) $user->phone = $request->json()->get('phone');
        $user->save();
        return $user;
    }

    public function update(Request $request, $id){
        $user = User::where('id', $id)
                    ->first();
        if($request->json()->get('role_id')) $user->role_id = $request->json()->get('role_id');
        if($request->json()->get('campa_id')) $user->campa_id = $request->json()->get('campa_id');
        if($request->json()->get('name')) $user->name = $request->json()->get('name');
        if($request->json()->get('email')) $user->email = $request->json()->get('email');
        if($request->json()->get('avatar')) $user->avatar = $request->json()->get('avatar');
        if($request->json()->get('phone')) $user->phone = $request->json()->get('phone');
        $user->updated_at = date('Y-m-d H:i:s');
        $user->save();
        return $user;
    }

    public function delete($id){
        User::where('id', $id)
                    ->delete();
        return [
            'message' => 'User deleted'
        ];
    }

    public function getUsersByCampa($campa_id){
        return User::where('campa_id', $campa_id)
                    ->get();
    }

    public function getUsersByRole(Request $request, $role_id){
        return User::with(['campa'])
                    ->where('role_id', $role_id)
                    ->where('campa_id', $request->json()->get('campa_id'))
                    ->get();
    }

    public function getActiveUsers(Request $request){
        return User::with(['campa'])
                    ->where('active', true)
                    ->where('campa_id', $request->json()->get('campa_id'))
                    ->get();
    }

    public function getUserByEmail(Request $request){
        return User::with(['campa'])
                    ->where('email', $request->json()->get('email'))
                    ->first();
    }
}
