<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Role;
use App\Repositories\RoleRepository;
use DateTime;

class RoleController extends Controller
{

    public function __construct(RoleRepository $roleRepository)
    {
        $this->roleRepository = $roleRepository;
    }

    public function getAll(){
        return Role::all();
    }

    public function getById($id){
        return $this->roleRepository->getById($id);
    }

    public function create(Request $request){

        $this->validate($request, [
            'description' => 'required|string'
        ]);

        return $this->roleRepository->create($request);
    }

    public function update(Request $request, $id){
        return $this->roleRepository->update($request, $id);
    }

    public function delete($id){
        return $this->roleRepository->delete($id);
    }
}
