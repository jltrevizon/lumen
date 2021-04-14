<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Region;
use App\Repositories\RegionRepository;

class RegionController extends Controller
{

    public function __construct(RegionRepository $regionRepository )
    {
        $this->regionRepository = $regionRepository;
    }

    public function getAll(){
        return Region::all();
    }

    public function getById($id){
        return $this->regionRepository->getById($id);
    }

    public function create(Request $request){
        return $this->regionRepository->create($request);
    }

    public function update(Request $request, $id){
        return $this->regionRepository->update($request, $id);
    }

    public function delete($id){
        return $this->regionRepository->delete($id);
    }
}
