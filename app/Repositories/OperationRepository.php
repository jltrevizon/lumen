<?php

namespace App\Repositories;

use App\Models\Operation;

class OperationRepository extends Repository {

    public function getAll($request){
        return Operation::with($this->getWiths($request->with))
                        ->filter($request->all())
                        ->get();
    }

    public function getById($request, $id){
        return Operation::findOrFail($id);
    }

    public function create($request){
        $operation = Operation::create($request->all());
        $operation->save();
        return $operation;
    }

    public function update($request, $id){
        $operation = Operation::findOrFail($id);
        $operation->update($request->all());
        return $operation;
    }
}
