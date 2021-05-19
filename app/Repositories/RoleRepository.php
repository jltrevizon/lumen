<?php

namespace App\Repositories;

use App\Models\Role;

class RoleRepository {

    public function __construct()
    {

    }

    public function getById($id){
        return Role::where('id', $id)
                    ->first();
    }

    public function create($request){
        $role = new Role();
        $role->description = $request->get('description');
        $role->save();
        return $role;
    }

    public function update($request, $id){
        $role = Role::where('id', $id)
                    ->first();
        $role->description = $request->get('description');
        $role->updated_at = date('Y-m-d H:i:s');
        $role->save();
        return $role;
    }

    public function delete($id){
        Role::where('id', $id)
            ->delete();
        return [
            'message' => 'Role deleted'
        ];
    }
}
