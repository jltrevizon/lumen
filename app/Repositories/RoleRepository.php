<?php

namespace App\Repositories;

use App\Models\Role;
use Exception;

class RoleRepository {

    public function __construct()
    {

    }

    public function getById($id){
        return Role::findOrFail($id);
    }

    public function create($request){
        $role = Role::create($request->all());
        $role->save();
        return $role;
    }

    public function update($request, $id){
        $role = Role::findOrFail($id);
        $role->update($request->all());
        return ['role' => $role];
    }

    public function delete($id){
        Role::where('id', $id)
            ->delete();
        return [ 'message' => 'Role deleted' ];
    }
}
