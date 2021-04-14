<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TypeRequest;
use App\Repositories\TransportRepository;

class TypeRequestController extends Controller
{

    public function __construct(TransportRepository $transportRepository)
    {
        $this->transportRepository = $transportRepository;
    }

    public function getAll(){
        return TypeRequest::all();
    }

    public function getById($id){
        return $this->transportRepository->getById($id);
    }

    public function create(Request $request){
        return $this->transportRepository->create($request);
    }

    public function update(Request $request, $id){
        return $this->transportRepository->update($request);
    }

    public function delete($id){
        return $this->transportRepository->delete($id);
    }
}
