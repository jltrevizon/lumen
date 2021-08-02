<?php

namespace App\Repositories;
use App\Models\User;
use Exception;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Hash;

class UserRepository extends Repository {

    public function __construct()
    {

    }

    public function getAll($request){
        return User::with($this->getWiths($request->with))
                    ->get();
    }

    public function getById($request, $id){
        return User::with($this->getWiths($request->with))
                    ->findOrFail($id);
    }

    public function create($request){
        $user = User::create($request->all());
        $user->save();
        return $user;
    }

    public function createUserWithoutPassword($request){
        $user = User::create($request->all());
        $user->save();
        return $user;
    }

    public function update($request, $id){
        $user = User::findOrFail($id);
        $user->update($request->all());
        return ['user' => $user];
    }

    public function delete($id){
        User::where('id', $id)
            ->delete();
        return [ 'message' => 'User deleted' ];
    }

    public function getUsersByCampa($campa_id){
        return User::whereHas('campas', fn (Builder $builder) => $builder->where('campas.id', $campa_id))
                ->get();
    }

    public function getUsersByRole($request, $role_id){
        return User::with($this->getWiths($request->with))
                ->where('role_id', $role_id)
                ->whereHas('campas', fn (Builder $builder) => $builder->whereIn('campas.id', $request->input('campas')))
                ->get();
    }

    public function getActiveUsers($request){
        return User::with($this->getWiths($request->with))
                ->where('active', true)
                ->whereHas('campas', fn (Builder $builder) => $builder->where('campas.id', $request->input('campa_id')))
                ->get();
    }

    public function getUserByEmail($request){
        return User::with($this->getWiths($request->with))
                ->where('email', $request->input('email'))
                ->first();
    }

}
