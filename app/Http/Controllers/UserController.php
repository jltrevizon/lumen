<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    public function getAll(){
        return User::all();
    }

    public function getById($id){
        return User::where('id', $id)
                    ->first();
    }

    public function createUserWithoutPassword(Request $request){
        $user = new User();
        $user->name = $request->get('name');
        $user->email = $request->get('email');
        $user->save();
        return $user;
    }

    public function update(Request $request, $id){
        $user = User::where('id', $id)
                    ->first();
        if(isset($request['role_id'])) $user->role_id = $request->get('role_id');
        if(isset($request['campa_id'])) $user->campa_id = $request->get('campa_id');
        if(isset($request['name'])) $user->name = $request->get('name');
        if(isset($request['email'])) $user->email = $request->get('email');
        if(isset($request['avatar'])) $user->avatar = $request->get('avatar');
        if(isset($request['phone'])) $user->phone = $request->get('phone');
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
        return User::where('role_id', $role_id)
                    ->where('campa_id', $request->get('campa_id'))
                    ->get();
    }

    public function getActiveUsers(Request $request){
        return User::where('active', true)
                    ->where('campa_id', $request->get('campa_id'))
                    ->get();
    }

    public function getUserByEmail(Request $request){
        return User::where('email', $request->get('email'))
                    ->first();
    }
}
