<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TypeTask;
use App\Repositories\TypeTaskRepository;

class TypeTaskController extends Controller
{

    public function __construct(TypeTaskRepository $typeTaskRepository)
    {
        $this->typeTaskRepository = $typeTaskRepository;
    }

    public function getAll(){
        return TypeTask::all();
    }

    public function getById($id){
        return $this->typeTaskRepository->getById($id);
    }

    public function create(Request $request){
        return $this->typeTaskRepository->create($request);
    }

    public function update(Request $request, $id){
        return $this->typeTaskRepository->update($request, $id);
    }

    public function delete($id){
        return $this->typeTaskRepository->delete($id);
    }
}
