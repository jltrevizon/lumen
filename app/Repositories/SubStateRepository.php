<?php

namespace App\Repositories;

use App\Models\SubState;
use Exception;

class SubStateRepository extends Repository {

    public function __construct()
    {

    }

    public function getAll($request){
        return SubState::with($this->getWiths($request->with))
            ->filter($request->all())
            ->get();
    }

    public function getById($id){
        return ['sub_state' => SubState::findOrFail($id)];
    }

    public function create($request){
        $sub_state = SubState::create($request->all());
        $sub_state->save();
        return $sub_state;
    }

    public function update($request, $id){
        $sub_state = SubState::findOrFail($id);
        $sub_state->update($request->all());
        return ['sub_state' => $sub_state];
    }

    public function delete($id){
        SubState::where('id', $id)
            ->delete();
        return [ 'message' => 'Sub state deleted' ];
    }

}
