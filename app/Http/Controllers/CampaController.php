<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Campa;
use App\Repositories\CampaRepository;
use Symfony\Component\HttpFoundation\Response as HttpFoundationResponse;

class CampaController extends Controller
{

    public function __construct(CampaRepository $campaRepository)
    {
        $this->campaRepository = $campaRepository;
    }

    public function getAll(Request $request){
        return $this->getDataResponse($this->campaRepository->getAll($request), HttpFoundationResponse::HTTP_OK);
    }

    public function getById(Request $request, $id){
        return $this->getDataResponse($this->campaRepository->getById($request, $id), HttpFoundationResponse::HTTP_OK);
    }

    public function getCampasByRegion(Request $request){

        $this->validate($request, [
            'region_id' => 'required|integer',
            'company_id' => 'required|integer'
        ]);

        return $this->getDataResponse($this->campaRepository->getCampasByRegion($request), HttpFoundationResponse::HTTP_OK);
    }

    public function getCampasByProvince(Request $request){

        $this->validate($request, [
            'province_id' => 'required|integer',
            'company_id' => 'required|integer'
        ]);

        return $this->getDataResponse($this->campaRepository->getCampasByProvince($request), HttpFoundationResponse::HTTP_OK);
    }

    public function getByCompany(Request $request){

        $this->validate($request, [
            'company_id' => 'required|integer'
        ]);

        return $this->getDataResponse($this->campaRepository->getByCompany($request), HttpFoundationResponse::HTTP_OK);
    }

    public function create(Request $request){

        $this->validate($request, [
            'company_id' => 'required|integer',
            'name' => 'required|string'
        ]);

        return $this->createDataResponse($this->campaRepository->create($request), HttpFoundationResponse::HTTP_OK);
    }

    public function update(Request $request, $id){
        return $this->updateDataResponse($this->campaRepository->update($request, $id), HttpFoundationResponse::HTTP_OK);
    }

    public function delete($id){
        Campa::where('id', $id)
            ->delete();

        return [ 'message' => 'Campa deleted' ];
    }
}
