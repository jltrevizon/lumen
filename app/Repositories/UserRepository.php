<?php

namespace App\Repositories;
use App\Models\User;
use Exception;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Hash;

class UserRepository {

    public function __construct()
    {

    }

    public function getById($id){
        try {
            $user = User::with(['campas'])
                        ->findOrFail($id);
            return response()->json(['user' => $user], 200);
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], 409);
        }
    }

    public function create($request){
        try {
            $user = new User();
            $user->name = $request->input('name');
            $user->email = $request->input('email');
            $user->password = Hash::make($request->input('password'));
            if($request->input('company_id')) $user->company_id = $request->input('company_id');
            if($request->input('role_id')) $user->role_id = $request->input('role_id');
            if($request->input('avatar')) $user->avatar = $request->input('avatar');
            if($request->input('phone')) $user->phone = $request->input('phone');
            $user->save();
            return $user;
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], 409);
        }
    }

    public function createUserWithoutPassword($request){
        try {
            $user = new User();
            $user->name = $request->input('name');
            $user->email = $request->input('email');
            if($request->input('company_id')) $user->company_id = $request->input('company_id');
            if($request->input('password')) $user->password = Hash::make($request->input('password'));
            if($request->input('role_id')) $user->role_id = $request->input('role_id');
            if($request->input('avatar')) $user->avatar = $request->input('avatar');
            if($request->input('phone')) $user->phone = $request->input('phone');
            $user->save();
            return $user;
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], 409);
        }
    }

    public function update($request, $id){
        try {
            $user = User::findOrFail($id);
            $user->update($request->all());
            return response()->json(['user' => $user], 200);
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], 409);
        }
    }

    public function delete($id){
        try {
            User::where('id', $id)
                        ->delete();
            return [
                'message' => 'User deleted'
            ];
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], 409);
        }
    }

    public function getUsersByCampa($campa_id){
        try {
            return User::whereHas('campas', fn (Builder $builder) => $builder->where('campas.id', $campa_id))
                        ->get();
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], 409);
        }
    }

    public function getUsersByRole($request, $role_id){
        try {
            return User::with(['campas','company'])
                        ->where('role_id', $role_id)
                        ->whereHas('campas', fn (Builder $builder) => $builder->where('campas.id', $request->input('campa_id')))
                        ->get();
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], 409);
        }
    }

    public function getActiveUsers($request){
        try {
            return User::with(['campas'])
                        ->where('active', true)
                        ->whereHas('campas', fn (Builder $builder) => $builder->where('campas.id', $request->input('campa_id')))
                        ->get();
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], 409);
        }
    }

    public function getUserByEmail($request){
        try {
            return User::with(['campas'])
                        ->where('email', $request->input('email'))
                        ->first();
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], 409);
        }
    }

}
