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
            return User::with(['campas'])
                        ->findOrFail($id);
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], 409);
        }
    }

    public function create($request){
        try {
            $user = User::create($request->all());
            $user->save();
            return $user;
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], 409);
        }
    }

    public function createUserWithoutPassword($request){
        try {
            $user = User::create($request->all());
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
            //return $role_id;
            return User::with(['campas','company'])
                        ->where('role_id', $role_id)
                        ->whereHas('campas', fn (Builder $builder) => $builder->whereIn('campas.id', $request->input('campas')))
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
