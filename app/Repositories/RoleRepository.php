<?php

namespace App\Repositories;

use App\Models\Role;
use Exception;

class RoleRepository {

    public function __construct()
    {

    }

    public function getById($id){
        try {
            return Role::findOrFail($id);
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], 409);
        }
    }

    public function create($request){
        try {
            $role = Role::create($request->all());
            $role->save();
            return $role;
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], 409);
        }
    }

    public function update($request, $id){
        try {
            $role = Role::findOrFail($id);
            $role->update($request->all());
            return response()->json(['role' => $role], 200);
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], 409);
        }
    }

    public function delete($id){
        try {
            Role::where('id', $id)
                ->delete();
            return [
                'message' => 'Role deleted'
            ];
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], 409);
        }
    }
}
