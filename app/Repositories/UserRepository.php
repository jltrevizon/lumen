<?php

namespace App\Repositories;
use App\Models\User;
use Exception;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
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
        return User::with(['campas'])
                    ->findOrFail($id);
    }

    public function create($request){
        $user = User::create($request->all());
        $user->password = app('hash')->make($request->input('password'));
        $user->save();
        return $user;
    }

    public function createUserWithoutPassword($request){
        $user = User::create($request->all());
        $user->password = app('hash')->make($request->input('password'));
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

    public function getUsersByRole($request, $role_id){
        return User::with($this->getWiths($request->with))
                ->where('role_id', $role_id)
                ->whereHas('campas', fn (Builder $builder) => $builder->whereIn('campas.id', $request->input('campas')))
                ->get();
    }

    public function getUserByEmail($email){
        return User::where('email', $email)
                ->first();
    }

    public function notifications($request){
        $user = Auth::user();
        return $user->notifications()->paginate();
    }

}
