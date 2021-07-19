<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Province;
use App\Repositories\ProvinceRepository;

class ProvinceController extends Controller
{

    public function __construct(ProvinceRepository $provinceRepository)
    {
        $this->provinceRepository = $provinceRepository;
    }

    public function getAll(){
        return Province::all();
    }

    public function getById($id){
        return $this->provinceRepository->getById($id);
    }

    public function provinceByRegion(Request $request){

        $this->validate($request, [
            'region_id' => 'required|integer'
        ]);

        return $this->provinceRepository->provinceByRegion($request);
    }

    public function create(Request $request){

        $this->validate($request, [
            'region_id' => 'required|integer',
            'province_code' => 'required|string',
            'name' => 'required|string'
        ]);

        return $this->provinceRepository->create($request);
    }

    public function update(Request $request, $id){
        return $this->provinceRepository->update($request, $id);
    }

    public function delete($id){
        return $this->provinceRepository->delete($id);
    }
}
