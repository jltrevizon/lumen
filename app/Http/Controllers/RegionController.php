<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Region;
use App\Repositories\RegionRepository;
use Symfony\Component\HttpFoundation\Response as HttpFoundationResponse;

class RegionController extends Controller
{

    public function __construct(RegionRepository $regionRepository)
    {
        $this->regionRepository = $regionRepository;
    }

    public function getAll(){
        return $this->getDataResponse(Region::all(), HttpFoundationResponse::HTTP_OK);
    }

    public function getById($id){
        return $this->getDataResponse($this->regionRepository->getById($id), HttpFoundationResponse::HTTP_OK);
    }

    public function create(Request $request){

        $this->validate($request, [
            'name' => 'required|string'
        ]);

        return $this->createDataResponse($this->regionRepository->create($request), HttpFoundationResponse::HTTP_CREATED);
    }

    public function update(Request $request, $id){
        return $this->updateDataResponse($this->regionRepository->update($request, $id), HttpFoundationResponse::HTTP_OK);
    }

    public function delete($id){
        return $this->deleteDataResponse($this->regionRepository->delete($id), HttpFoundationResponse::HTTP_OK);
    }
}
