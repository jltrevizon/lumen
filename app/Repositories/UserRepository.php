<?php

namespace App\Repositories;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Hash;

class UserRepository {

    public function __construct()
    {

    }

    public function getById($id){
        return User::with(['campas'])
                    ->where('id', $id)
                    ->first();
    }

    public function create($request){
        $user = new User();
        $user->name = $request->json()->get('name');
        $user->email = $request->json()->get('email');
        $user->password = Hash::make($request->json()->get('password'));
        if($request->json()->get('company_id')) $user->company_id = $request->json()->get('company_id');
        if($request->json()->get('role_id')) $user->role_id = $request->json()->get('role_id');
        if($request->json()->get('avatar')) $user->avatar = $request->json()->get('avatar');
        if($request->json()->get('phone')) $user->phone = $request->json()->get('phone');
        $user->save();
        return $user;
    }

    public function createUserWithoutPassword($request){
        $user = new User();
        $user->name = $request->json()->get('name');
        $user->email = $request->json()->get('email');
        if($request->json()->get('company_id')) $user->company_id = $request->json()->get('company_id');
        if($request->json()->get('password')) $user->password = Hash::make($request->json()->get('password'));
        if($request->json()->get('role_id')) $user->role_id = $request->json()->get('role_id');
        if($request->json()->get('avatar')) $user->avatar = $request->json()->get('avatar');
        if($request->json()->get('phone')) $user->phone = $request->json()->get('phone');
        $user->save();
        return $user;
    }

    public function update($request, $id){
        $user = User::where('id', $id)
                    ->first();
        if($request->json()->get('password')) $user->password = Hash::make($request->json()->get('password'));
        if($request->json()->get('company_id')) $user->company_id = $request->json()->get('company_id');
        if($request->json()->get('role_id')) $user->role_id = $request->json()->get('role_id');
        if($request->json()->get('name')) $user->name = $request->json()->get('name');
        if($request->json()->get('surname')) $user->surname = $request->json()->get('surname');
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
        return User::whereHas('campas', fn (Builder $builder) => $builder->where('campas.id', $campa_id))
                    ->get();
    }

    public function getUsersByRole($request, $role_id){
        return User::with(['campas'])
                    ->where('role_id', $role_id)
                    ->whereHas('campas', fn (Builder $builder) => $builder->where('campas.id', $request->json()->get('campa_id')))
                    ->get();
    }

    public function getActiveUsers($request){
        return User::with(['campas'])
                    ->where('active', true)
                    ->whereHas('campas', fn (Builder $builder) => $builder->where('campas.id', $request->json()->get('campa_id')))
                    ->get();
    }

    public function getUserByEmail($request){
        return User::with(['campas'])
                    ->where('email', $request->json()->get('email'))
                    ->first();
    }

}
