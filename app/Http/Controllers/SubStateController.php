<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SubState;
use App\Repositories\SubStateRepository;

class SubStateController extends Controller
{

    public function __construct(SubStateRepository $subStateRepository)
    {
        $this->subStateRepository = $subStateRepository;
    }

    public function getAll(){
        return SubState::with(['state'])
                    ->get();
    }

    public function getById($id){
        return $this->subStateRepository->getById($id);
    }

    public function create(Request $request){

        $this->validate($request, [
            'state_id' => 'required|integer',
            'name' => 'required|string'
        ]);

        return $this->subStateRepository->create($request);
    }

    public function update(Request $request, $id){
        return $this->subStateRepository->update($request, $id);
    }

    public function delete($id){
        return $this->subStateRepository->update($id);
    }
}
