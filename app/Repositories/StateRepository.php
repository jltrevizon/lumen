<?php

namespace App\Repositories;

use App\Models\State;
use Exception;
use Illuminate\Database\Eloquent\Builder;

class StateRepository {

    public function __construct()
    {

    }

    public function getAll($request){
        return State::with($this->getWiths($request->with))
                    ->filter($request->all())
                    ->get();
    }

    public function getById($id){
        return ['state' => State::findOrFail($id)];
    }

    public function create($request){
        $state = State::create($request->all());
        $state->save();
        return $state;
    }

    public function update($request, $id){
        $state = State::findOrFail($id);
        $state->update($request->all());
        return ['state' => $state];
    }

    public function delete($id){
        State::where('id', $id)
            ->delete();
        return [ 'message' => 'State deleted' ];
    }
}
