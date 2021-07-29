<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Province;
use App\Repositories\ProvinceRepository;
use Symfony\Component\HttpFoundation\Response as HttpFoundationResponse;

class ProvinceController extends Controller
{

    public function __construct(ProvinceRepository $provinceRepository)
    {
        $this->provinceRepository = $provinceRepository;
    }

    public function getAll(){
        return $this->getDataResponse(Province::all(), HttpFoundationResponse::HTTP_OK);
    }

    public function getById($id){
        return $this->getDataResponse($this->provinceRepository->getById($id), HttpFoundationResponse::HTTP_OK);
    }

    public function provinceByRegion(Request $request){

        $this->validate($request, [
            'region_id' => 'required|integer'
        ]);

        return $this->getDataResponse($this->provinceRepository->provinceByRegion($request), HttpFoundationResponse::HTTP_OK);
    }

    public function create(Request $request){

        $this->validate($request, [
            'region_id' => 'required|integer',
            'province_code' => 'required|string',
            'name' => 'required|string'
        ]);

        return $this->createDataResponse($this->provinceRepository->create($request), HttpFoundationResponse::HTTP_OK);
    }

    public function update(Request $request, $id){
        return $this->updateDataResponse($this->provinceRepository->update($request, $id), HttpFoundationResponse::HTTP_OK);
    }

    public function delete($id){
        return $this->deleteDataResponse($this->provinceRepository->delete($id), HttpFoundationResponse::HTTP_OK);
    }
}
