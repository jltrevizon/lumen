<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Role;
use DateTime;

class RoleController extends Controller
{
    public function getAll(){
        return Role::all();
    }

    public function getById($id){
        return Role::where('id', $id)
                    ->first();
    }

    public function create(Request $request){
        $role = new Role();
        $role->description = $request->get('description');
        $role->save();
        return $role;
    }

    public function update(Request $request, $id){
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
