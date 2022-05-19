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

    public function index(Request $request){
        return $this->getDataResponse($this->campaRepository->index($request), HttpFoundationResponse::HTTP_OK);
    }

    public function show(Request $request, $id){
        return $this->getDataResponse($this->campaRepository->show($request, $id), HttpFoundationResponse::HTTP_OK);
    }

    public function create(Request $request){

        $this->validate($request, [
            'company_id' => 'required|integer',
            'name' => 'required|string'
        ]);

        return $this->createDataResponse($this->campaRepository->create($request), HttpFoundationResponse::HTTP_CREATED);
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
